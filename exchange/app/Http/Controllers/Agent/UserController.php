<?php

/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2018/12/4
 * Time: 16:36
 */

namespace App\Http\Controllers\Agent;

use App\Logic\User as UserLogic;
use App\Models\User\Token;
use Illuminate\Http\Request;
use App\Models\Account\{AccountLog,ChangeAccountLog ,AccountDraw};
use App\Models\Agent\Agent;
use App\Models\User\User;
use App\Models\Currency\Currency;

class UserController extends Controller
{

    //用户管理
    public function index()
    {
        //某代理商下用户时
        $parent_id = request()->get('parent_id', 0);
        //币币
        // $legal_currencies = Currency::where('is_change', 1)->get();
        // $legal_currencies = Currency::all();
        // var_dump($legal_currencies);
        return view("agent.user.index", ['parent_id' => $parent_id]);
    }

    public function edit()
    {
        $user_id = request()->get('user_id', 0);
        $user = User::findOrFail($user_id);

        return view("agent.user.edit", ['user' => $user]);
    }

    public function update(Request $request)
    {
        try {
            $user_id = $request->get('user_id', 0);
            $micro_cont_status = $request->get("micro_cont_status",0);//
            $micro_risk_profit_probability = $request->get("micro_risk_profit_probability",0);//
            $credit_score = $request->get("credit_score",0);//

            $user = User::where('id', $user_id)->firstOrFail();

            $user->micro_cont_status = $micro_cont_status;
            $user->micro_risk_profit_probability = $micro_risk_profit_probability;
            $user->credit_score = $credit_score;

            $user->save();
            return $this->success('操作成功');
        } catch (\Exception $e) {
            return $this->error('操作失败');
        }

    }
    //用户列表
    public function lists(Request $request)
    {
        $limit = $request->get('limit', 10);
        $id = request()->input('id', 0);
        $parent_id = request()->input('parent_id', 0);
        $uid = request()->input('uid', '');
        $mobile = request()->input('mobile', '');
        $email = request()->input('email', '');
        $start = request()->input('start', '');
        $end = request()->input('end', '');

        $users = new User();
        $agent_id = Agent::getAgentId();

        if ($id) {
            $users = $users->where('id', $id);
        }

        if ($parent_id > 0) {
            $users = $users->where('agent_node_id', $parent_id);
        }else{

            $users = $users->whereRaw("FIND_IN_SET($agent_id,agent_path)");

        }
        if ($uid) {
            $users = $users->where('uid', $uid);
        }
        if ($mobile) {
            $users = $users->where('mobile', $mobile);
        }
        if ($email) {
            $users = $users->where('email', $email);
        }
        // if (!empty($start) && !empty($end)) {
        //     $users->whereBetween('created_at', [$start,$end]);
        // }

        if (!empty($start)) {
            $users =$users->where('created_at','>=',$start);
        }
        if (!empty($end)) {
            $users =$users->where('created_at','<=',$end);
        }

        $list = $users->paginate($limit);

        $items = $list->getCollection();
        $items->transform(function ($item, $key){

            $item->setAppends(['my_agent_level','parent_agent_name']);

            return $item;
        });
        $list->setCollection($items);

        return $this->layuiPageData($list);
    }

    /**
     * 获取用户管理的统计
     * @param Request $r
     */
    public function getUserNum(Request $request)
    {

        $id             = request()->input('id', 0);
        $uid = request()->input('uid', '');
        $mobile = request()->input('mobile', '');
        $email = request()->input('email', '');
        $parent_id            = request()->input('parent_id', 0);//代理商id
        $start = request()->input('start', '');
        $end = request()->input('end', '');
        $currency_id = request()->input('currency_id', '');

        $users = new User();
        $agent_id = Agent::getAgentId();

        if ($id) {
            $users = $users->where('id', $id);
        }
        if ($parent_id > 0) {
            $users = $users->where('agent_node_id', $parent_id);
        }else{

            $users = $users->whereRaw("FIND_IN_SET($agent_id,`agent_path`)");

        }
        if ($uid) {
            $users = $users->where('uid', $uid);
        }
        if ($mobile) {
            $users = $users->where('mobile', $mobile);
        }
        if ($email) {
            $users = $users->where('email', $email);
        }
        if (!empty($start) && !empty($end)) {
            $users->whereBetween('created_at', [$start,$end]);
        }

        $users_id = $users->get()->pluck('id')->all();
        $_daili = 0;
        $_ru = 0.00;
        $_chu = 0.00;
        $_num = 0;

        $_num = $users->count();

        $_daili = $users->where('agent_id', '>', 0)->count();


        $_ru = ChangeAccountLog::where('type', AccountLog::BLOCK_CHAIN_ADD[0])
            ->whereIn('user_id', $users_id)
            ->when($currency_id > 0, function ($query) use ($currency_id) {
                $query->where('currency_id', $currency_id);
            })->sum('value');

        $_chu =AccountDraw::where('status', 4)
            ->whereIn('user_id', $users_id)
            ->when($currency_id > 0, function ($query) use ($currency_id) {
                $query->where('currency_id', $currency_id);
            })->sum('real_number');

        $data = [];
        $data['_num'] = $_num;
        $data['_daili'] = $_daili;
        $data['_ru'] = $_ru;
        $data['_chu'] = $_chu;


        return $this->ajaxReturn($data);
    }



    //我的邀请二维码
    public function get_my_invite_code()
    {

        $_self = Agent::getAgent();

        if ($_self == null) {
            return $this->error('信息有误');
        }

        $use = User::getById($_self->user_id);

        return $this->ajaxReturn(['invite_code' => $use->extension_code, 'is_admin' => $_self->is_admin]);
    }

    //代理商管理
    public function salesmenIndex()
    {
        return view("agent.salesmen.index");
    }

    //添加代理商页面
    public function salesmenAdd()
    {
        $data = request()->all();

        return view("agent.salesmen.add", ['d' => $data]);
    }

    public function salesmenEdit()
    {
        $data = request()->all();
        return view("agent.salesmen.add", ['d' => $data]);
    }

}
