<?php

namespace App\Http\Controllers\Agent;

use App\Models\Micro\MicroOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Tx\TxComplete;
use App\Models\Currency\{Currency, CurrencyMatch};
use App\Models\Account\{AccountLog, Account, ChangeAccount};
use App\Models\Agent\{Agent, AgentMoneyLog};
use App\Models\User\User;
use App\Models\Lever\LeverTransaction;
use App\Jobs\SettleLever;
use App\Models\Tx\TxHistory;

/**
 * 该类处理所有的订单与结算。
 * Class ReportController
 *
 * @package App\Http\Controllers\Agent
 */
class MicroOrderController extends Controller
{


    /**
     * 结算列表首页
     */
    public function jieIndex(Request $request)
    {
        //计价币
        $legal_currencies = Currency::where('is_quote', Currency::ON)->get();
        //下级代理
        $son_agents = Agent::getAllChildAgent(Agent::getAgentId());
        $self = Agent::getAgent();
        $is_admin = $self ? $self->is_admin : 0;
        return view('agent.order.settle_micro', [
            'legal_currencies' => $legal_currencies,
            'son_agents' => $son_agents,
            'is_admin' => $is_admin
        ]);
    }

    public function jieList(Request $request)
    {

        $limit = $request->input("limit", 10);
        $start = $request->input("start", '');
        $end = $request->input("end", '');

        $agent_id = Agent::getAgentId();
        $child_agents = Agent::getAllChildAgent($agent_id);
        $son_agents = $child_agents->pluck('id')->all();

        $lists = AgentMoneyLog::with(['user'])->whereIn('agent_id', $son_agents)
            ->where(function ($query) use ($request) {

                $belong_agent = $request->input('belong_agent', '');
                $quote_currency_id = $request->input('quote_currency_id', -1);

                $type = $request->input("type", 0); //1 头寸  2手续费

                $query->when($belong_agent != '', function ($query) use ($belong_agent) {
                    $query->whereHas('agent', function ($query) use ($belong_agent) {
                        $query->where('username', $belong_agent);
                    });
                })->when($quote_currency_id > 0, function ($query) use ($quote_currency_id) {
                    $query->where('quote_currency_id', $quote_currency_id);
                })->when($type > 0, function ($query) use ($type) {
                    $query->where('type', $type);
                });
            })->where(function ($query) use ($start, $end) {
                !empty($start) && $query->where('created_time', '>=', strtotime($start . ' 0:0:0'));
                !empty($end) && $query->where('created_time', '<=', strtotime($end . ' 23:59:59'));
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return $this->layuiPageData($lists);
    }


    //合约订单结算（对账）
    public function dojie(Request $request)
    {

        $start = $request->input("start", '');
        $end = $request->input("end", '');
        $id = $request->input("id", 0);
        $mobile = $request->input("mobile", '');
        $uid = $request->input("uid", '');
        $email = $request->input("email", '');
        $belong_agent = $request->input('belong_agent', '');
        $quote_currency_id = $request->input('quote_currency_id', -1);

        //超级代理 有权限
        $self = Agent::getAgent();
        if ($self->is_admin != 1) {
            return $this->error('只有超级代理才有权限');
        }
        $agent_id = $self->id;

        if ($belong_agent) {
            $search_agent = Agent::where('username', $belong_agent)->first();
        }
        if (!$search_agent) {
            return $this->error('代理商不存在');
        } else {
            $parent_agent = explode(',', $search_agent->agent_path);
            if (!in_array($agent_id, $parent_agent)) {
                return $this->error('该代理商并不属于您的团队');
            }
            $agent_id = $search_agent->id;
        }

        $now_agent_id = $agent_id;

        $lever_ids = LeverTransaction::whereHas('user', function ($query) use ($mobile, $email, $uid) {

            $mobile != '' && $query->mobile('mobile', $mobile);
            $email != '' && $query->mobile('email', $email);
            $uid != '' && $query->mobile('uid', $uid);

        })->where(function ($query) use ($start, $end) {
            //平仓时间
            !empty($start) && $query->where('complete_time', '>=', strtotime($start . ' 0:0:0'));

            !empty($end) && $query->where('complete_time', '<=', strtotime($end . ' 23:59:59'));
        })->where(function ($query) use ($now_agent_id) {

            $now_agent_id > 0 && $query->whereRaw("FIND_IN_SET($now_agent_id,`agent_path`)");
        })->when($quote_currency_id > 0, function ($query) use ($quote_currency_id) {

            $query->where('quote_currency_id', $legal_id);
        })->when($id > 0, function ($query) use ($id) {
            $query->where('id', $id);
        })->where('status', LeverTransaction::STATUS_CLOSED)
            ->where('settled', 0)
            ->get()->pluck('id')->all();

        //dd($lever_ids);

        if (!empty($lever_ids)) {

            SettleLever::dispatch($lever_ids)->onQueue('dojie');
        }

        return $this->success('正在结算～请稍后刷新页面');
    }

    //结算 提现到账
    public function walletOut(Request $request)
    {
        $id = $request->get('id', '');

        if (!$id) {
            return $this->error('参数错误');
        }

        try {
            DB::beginTransaction();
            $agent_log = AgentMoneyLog::lockForUpdate()->find($id);
            if (empty($agent_log)) {
                throw new \Exception('信息有误');
            }
            $agent = Agent::find($agent_log->agent_id);
            if ($agent->is_admin != 1) {

                $wallet = ChangeAccount::where('user_id', $agent->user_id)
                    ->where('currency_id', $agent_log->quote_currency_id)->lockForUpdate()->first();
                if (empty($wallet)) {
                    throw new \Exception('用户钱包不存在');
                }
                if ($agent_log->type == 1) {

                    $account_type = AccountLog::AGENT_JIE_TC_MONEY;
                    $account_info = '代理商结算头寸收益 划转到账';
                } else {
                    $account_type = AccountLog::AGENT_JIE_SX_MONEY;
                    $account_info = '代理商结算手续费收益 划转到账';
                }
                $wallet->changeBalance(AccountLog::CHANGE_BALANCE, $agent_log->change, ['memo' => $account_info]);
                // $wallet->changeBalance(Account::CHANGE_BALANCE, $account_type,$agent_log->change, ['memo' =>$account_info]);

            } else {
                throw new \Exception('超管无法提现');
            }


            $agent_log->status = 1; //
            $agent_log->updated_time = time(); //

            $agent_log->save();

            DB::commit();
            return $this->success('操作成功:)');
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage());
        }
    }


    /**
     * 交割订单详情
     */
    public function orderInfo(Request $request)
    {
        $order_id = $request->input("order_id", 0);
        if ($order_id > 0) {

            $orderinfo = LeverTransaction::where('id', $order_id)->first();
            $user = User::where('id', $orderinfo->user_id)->first();
            if (empty($user)) {
                $orderinfo->uid = "无";
                $orderinfo->mobile = "无";
                $orderinfo->email = "无";

            } else {
                $orderinfo->uid = $user->uid;
                $orderinfo->mobile = $user->mobile;
                $orderinfo->email = $user->email;
            }

            if (empty($orderinfo)) {
                return $this->error('订单编号错误或者您无权查看订单详情');
            } else {

                return view("agent.order.micro_order_info", ['info' => $orderinfo]);
            }
        } else {
            return $this->error('非法参数');
        }
    }

}
