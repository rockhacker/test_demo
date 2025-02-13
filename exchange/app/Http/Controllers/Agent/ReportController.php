<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Agent\{Agent,AgentMoneyLog};
use App\Models\User\User as Users;
use App\Models\Lever\LeverTransaction;
/**
 * 该类处理所有的统计报表数据。
 * Class ReportController
 * @package App\Http\Controllers\Agent
 */
class ReportController extends Controller
{



    //订单统计
    public function orderSt()
    {
        return view("agent.statistics.order");
    }

    //用户统计
    public function userSt()
    {
        return view("agent.statistics.user");
    }

    //收益统计
    public function moneySt()
    {
        return view("agent.statistics.money");
    }

    //日订单量
    public function day()
    {

        $agent_id = Agent::getAgentId();

        $day = [];
        $info = [];

        for ($i = 0; $i < 24; $i++) {
            $day[] = $i . '点';

            $start = strtotime(date('Y-m-d') . ' ' . $i . ':0:0');
            $end = strtotime(date('Y-m-d') . ' ' . $i . ':59:59');

            $info[] = LeverTransaction::whereIn('status', [LeverTransaction::STATUS_TRANSACTION, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereRaw("FIND_IN_SET($agent_id,`agent_path`)")->whereBetween('create_time', [$start, $end])->count();
        }

        $data = [];
        $data['day'] = $day;
        $data['info'] = $info;

        return $this->ajaxReturn($data);
    }


    public function jie(Request $request)
    {

        $type  = $request->input('type', '');
        if (!empty($type) && in_array($type, ['all', 'search'])) {

            $returnData = [];

            //以周为单位获取每天的时间戳
            $a = Agent::get_weeks(date("Y-m-d", strtotime("-1 year")), date('Y-m-d'));

            $b = [];
            $c = [];
            for ($i = 0; $i < count($a); $i++) {
                $jo = explode('/', $a[$i]);
                $start = strtotime($jo[0] . ' 0:0:0');
                $end = strtotime($jo[1] . ' 23:59:59');
                $b[] = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSED)->where('settled', 0)->whereBetween('complete_time', [$start, $end])->count();
                $_z = count($a) - 1 - $i;
                if ($_z == 0) {
                    $c[] = '本周';
                } else {
                    $c[] = $_z . '周前';
                }
            }
            $returnData['series'] = $b;
            $returnData['xAxis'] = $c;

            return $this->ajaxReturn($returnData);
        } else {
            return $this->error('非法操作');
        }
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(Request $request)
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        //$sons = $this->get_my_sons();

        //获取伞下用户
        $node_users=Users::whereRaw("FIND_IN_SET($_self->id,`agent_path`)")->pluck('id')->all();

        $type  = $request->input('type', '');
        if (!empty($type) && in_array($type, ['all', 'search'])) {

            $returnData = [];

            //以周为单位获取每天的时间戳
            $a = Agent::get_weeks(date("Y-m-d", strtotime("-1 year")), date('Y-m-d'));

            $b = [];
            $c = [];
            for ($i = 0; $i < count($a); $i++) {
                $jo = explode('/', $a[$i]);
                $start = strtotime($jo[0] . ' 0:0:0');
                $end = strtotime($jo[1] . ' 23:59:59');
                $b[] = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSED)->whereBetween('complete_time', [$start, $end])->whereIn('user_id',$node_users)->count();
                $d[] = DB::table('lever_transaction')->whereIn('status',[LeverTransaction::STATUS_TRANSACTION, LeverTransaction::STATUS_CLOSING])->whereBetween('create_time', [$start, $end])->whereIn('user_id', $node_users)->count();
                $_z = count($a) - 1 - $i;
                if ($_z == 0) {
                    $c[] = '本周';
                } else {
                    $c[] = $_z . '周前';
                }
            }
            $returnData['series'] = $b;
            $returnData['selling'] = $d;
            $returnData['xAxis'] = $c;

            return $this->ajaxReturn($returnData);
        } else {
            return $this->error('非法操作');
        }
    }

    //
    public function order_num()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

       // $sons = $this->get_my_sons();
       //获取伞下用户
       $node_users=Users::whereRaw("FIND_IN_SET($_self->id,`agent_path`)")->pluck('id')->all();

        //交易中的订单数量
        $a = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_TRANSACTION)->whereIn('user_id', $node_users)->count();
        //平仓中的订单数量
        $b = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSING)->whereIn('user_id', $node_users)->count();
        //已平仓的订单数量
        $c = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSED)->whereIn('user_id', $node_users)->count();

        $data = [];
        $data['a'] = $a;
        $data['b'] = $b;
        $data['c'] = $c;

        return $this->ajaxReturn($data);
    }


   //统计有问题？？  待优化
    public function order_money()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        //$sons = $this->get_my_sons();
        //获取伞下用户
       $node_users=Users::whereRaw("FIND_IN_SET($_self->id,`agent_path`)")->pluck('id')->all();

        //交易中
        $a = DB::table('lever_transaction')->where('status', LeverTransaction::WAY_BUY)->whereIn('user_id', $node_users)->sum('price');
        //平仓中
        $b = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSING)->whereIn('user_id', $node_users)->sum('price');
        //已平仓
        $c = DB::table('lever_transaction')->where('status', LeverTransaction::STATUS_CLOSED)->whereIn('user_id', $node_users)->sum('price');

        $data = [];
        $data['a'] = $a;
        $data['b'] = $b;
        $data['c'] = $c;

        return $this->ajaxReturn($data);
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        //$sons = $this->get_my_sons();

        //伞下代理商及用户id
        $agent_id = $_self->id;
        $node_users = Users::whereRaw("FIND_IN_SET($agent_id,`agent_path`)")->pluck('id')->all();

        $returnData = [];

        //以周为单位获取每天的时间戳
        $a = Agent::get_weeks(date("Y-m-d", strtotime("-1 year")), date('Y-m-d'));

        $b = [];
        $c = [];
        $d = [];
        for ($i = 0; $i < count($a); $i++) {
            $jo = explode('/', $a[$i]);
            $start = strtotime($jo[0] . ' 0:0:0');
            $end = strtotime($jo[1] . ' 23:59:59');
            //活跃用户
             $count= LeverTransaction::whereIn('status', [LeverTransaction::STATUS_TRANSACTION, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereBetween('create_time', [$start, $end])->whereIn('user_id', $node_users)->select("user_id")->groupBy('user_id')->get()->toArray();
             $b[]=count($count);

            //注册用户
            $d[] = DB::table('users')->whereBetween('time', [$start, $end])->whereIn('id', $node_users)->count();
            $_z = count($a) - 1 - $i;
            if ($_z == 0) {
                $c[] = '本周';
            } else {
                $c[] = $_z . '周前';
            }
        }
        $returnData['huoyue'] = $b;
        $returnData['reg'] = $d;
        $returnData['xAxis'] = $c;

        return $this->ajaxReturn($returnData);
    }


    //统计用户  代理商数据 待优化
    public function user_num()
    {
        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        $sons = $this->get_my_sons();

        $data = [];
        $data['san'] = count($sons['san']);
        $data['one'] = count($sons['one']);
        $data['two'] = count($sons['two']);
        $data['three'] = count($sons['three']);
        $data['four'] = count($sons['four']);

        return $this->ajaxReturn($data);
        //$son=Users::where('agent_id',0)->whereRaw("FIND_IN_SET($_self->id,`agent_path`)")->count();

    }


    //统计收益 待优化
    public function user_money()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        $sons = $this->get_my_sons();

        $data = [];
        $data['san'] =  DB::table('lever_transaction')->whereIn('status', [LeverTransaction::WAY_BUY, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereIn('user_id', $sons['san'])->sum('price');
        $data['one'] = DB::table('lever_transaction')->whereIn('status', [LeverTransaction::WAY_BUY, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereIn('user_id', $sons['one'])->sum('price');
        $data['two'] = DB::table('lever_transaction')->whereIn('status', [LeverTransaction::WAY_BUY, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereIn('user_id', $sons['two'])->sum('price');
        $data['three'] = DB::table('lever_transaction')->whereIn('status', [LeverTransaction::WAY_BUY, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereIn('user_id', $sons['three'])->sum('price');
        $data['four'] = DB::table('lever_transaction')->whereIn('status', [LeverTransaction::WAY_BUY, LeverTransaction::STATUS_CLOSING, LeverTransaction::STATUS_CLOSED])->whereIn('user_id', $sons['four'])->sum('price');

        return $this->ajaxReturn($data);
    }


    /** 代理商及其下级代理商的头寸 手续费收益
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agental(Request $request)
    {


        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        //$sons = $this->get_my_sons();

        $child_agents = Agent::getAllChildAgent($_self->id);
        $son_agents = $child_agents->pluck('id')->all();

        $returnData = [];

        //以周为单位获取每天的时间戳
        $a = Agent::get_weeks(date("Y-m-d", strtotime("-1 year")), date('Y-m-d'));

        $b = [];
        $c = [];
        $d = [];
        for ($i = 0; $i < count($a); $i++) {
            $jo = explode('/', $a[$i]);
            $start = strtotime($jo[0] . ' 0:0:0');
            $end = strtotime($jo[1] . ' 23:59:59');
            //头寸收益
            $b[] = AgentMoneyLog::whereIn('agent_id', $son_agents)->whereBetween('created_time', [$start, $end])->where('type', 1)->sum('change');
            //手续费收益
            $d[] =AgentMoneyLog::whereIn('agent_id', $son_agents)->whereBetween('created_time', [$start, $end])->where('type', 2)->sum('change');
            $_z = count($a) - 1 - $i;
            if ($_z == 0) {
                $c[] = '本周';
            } else {
                $c[] = $_z . '周前';
            }
        }
        $returnData['tocufy'] = $b;
        $returnData['sxuf'] = $d;
        $returnData['xAxis'] = $c;

        return $this->ajaxReturn($returnData);
    }

//待优化
    public function agental_t()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        $sons = $this->get_my_sons();

        $data = [];
        $data['san'] =0; //DB::table('agent_money_log')->where('agent_id' , $_self->id)->where('type' , 2)->whereIn('son_user_id' , $sons['san'])->sum('change');
        $data['one'] = 61; //DB::table('agent_money_log')->where('agent_id' , $_self->id)->where('type' , 2)->whereIn('son_user_id' , $sons['one'])->sum('change');
        $data['two'] = 19; //DB::table('agent_money_log')->where('agent_id' , $_self->id)->where('type' , 2)->whereIn('son_user_id' , $sons['two'])->sum('change');
        $data['three'] = DB::table('agent_money_log')->where('agent_id', $_self->id)->where('type', 2)->whereIn('son_user_id', $sons['three'])->sum('change');
        $data['four'] = DB::table('agent_money_log')->where('agent_id', $_self->id)->where('type', 2)->whereIn('son_user_id', $sons['four'])->sum('change');

        return $this->ajaxReturn($data);
    }

//待优化
    public function agental_s()
    {

        $_self = Agent::getAgent();
        if ($_self === null) {
            return $this->outmsg('发生错误！请重新登录');
        }

        $sons = $this->get_my_sons();

        $data = [];
        $data['san'] =  0; //DB::table('agent_money_log')->where('agent_id' , $_self->id)->where('type' , 1)->whereIn('son_user_id' , $sons['san'])->sum('change');
        $data['one'] = DB::table('agent_money_log')->where('agent_id', $_self->id)->where('type', 1)->whereIn('son_user_id', $sons['one'])->sum('change');
        $data['two'] = 8; //DB::table('agent_money_log')->where('agent_id' , $_self->id)->where('type' , 1)->whereIn('son_user_id' , $sons['two'])->sum('change');
        $data['three'] = DB::table('agent_money_log')->where('agent_id', $_self->id)->where('type', 1)->whereIn('son_user_id', $sons['three'])->sum('change');
        $data['four'] = DB::table('agent_money_log')->where('agent_id', $_self->id)->where('type', 1)->whereIn('son_user_id', $sons['four'])->sum('change');

        return $this->ajaxReturn($data);
    }





    /**
     * 获取我的所有的下级。包括所有的散户和各级代理商
     */
    public function get_my_sons($agent_id = 0)
    {

        if ($agent_id === 0) {
            $_self = Agent::getAgent();
        } else {
            $_self = Agent::getAgentById($agent_id);
        }

        $_one = [];
        $_one_sons = [];
        $_two = [];
        $_two_sons = [];
        $_three = [];
        $_three_sons = [];
        $_four = [];
        $_four_sons = [];
        switch ($_self->level) {
            case 0:
                $_one = DB::table('agent')->where('level', 1)->select('user_id', 'id')->get()->toArray();
                $_two = DB::table('agent')->where('level', 2)->select('user_id', 'id')->get()->toArray();
                $_three = DB::table('agent')->where('level', 3)->select('user_id', 'id')->get()->toArray();
                $_four = DB::table('agent')->where('level', 4)->select('user_id', 'id')->get()->toArray();
                break;

            case 1:
                $_two = DB::table('agent')->where('parent_agent_id', $_self->id)->get()->toArray();
                $_one_sons = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $_self->id)->get()->toArray();

                if (!empty($_two)) {
                    foreach ($_two as $key => $value) {
                        $_a = DB::table('agent')->where('parent_agent_id', $value->id)->get()->toArray();
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_three = array_merge($_three, $_a);
                        $_two_sons = array_merge($_two_sons, $_b);
                    }
                }

                if (!empty($_three)) {
                    foreach ($_three as $key => $value) {
                        $_a = DB::table('agent')->where('parent_agent_id', $value->id)->get()->toArray();
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_four = array_merge($_four, $_a);
                        $_three_sons = array_merge($_three_sons, $_b);
                    }
                }

                if (!empty($_four)) {
                    foreach ($_four as $key => $value) {
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_three_sons = array_merge($_three_sons, $_b);
                    }
                }

                break;
            case 2:
                $_three = DB::table('agent')->where('parent_agent_id', $_self->id)->get()->toArray();
                $_two_sons = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $_self->id)->get()->toArray();
                if (!empty($_two)) {
                    foreach ($_two as $key => $value) {
                        $_a = DB::table('agent')->where('parent_agent_id', $value->id)->get()->toArray();
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_four = array_merge($_four, $_a);
                        $_three_sons = array_merge($_three_sons, $_b);
                    }
                }

                if (!empty($_four)) {
                    foreach ($_four as $key => $value) {
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_four_sons = array_merge($_four_sons, $_b);
                    }
                }
                break;
            case 3:
                $_four = DB::table('agent')->where('parent_agent_id', $_self->id)->get()->toArray();
                $_three_sons = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $_self->id)->get()->toArray();

                if (!empty($_four)) {
                    foreach ($_four as $key => $value) {
                        $_b = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $value->id)->get()->toArray();
                        $_four_sons = array_merge($_four_sons, $_b);
                    }
                }
                break;
            case 4:
                $_four_sons = DB::table('users')->where('agent_id', 0)->where('agent_node_id', $_self->id)->get()->toArray();
                break;
        }

        if ($_self->level == 0  && $_self->is_admin == 1) {
            $san_user = DB::table('users')->where('agent_id', 0)->get()->toArray();  //所有的散户
            $san_user = $this->sel_agent_arr($san_user);
        } else {
            $a = $this->sel_agent_arr($_one_sons);
            $b = $this->sel_agent_arr($_two_sons);
            $c = $this->sel_agent_arr($_three_sons);
            $d = $this->sel_agent_arr($_four_sons);
            $san_user = array_merge($a, $b, $c, $d);
        }

        $data = [];
        $data['san'] = $san_user;
        $data['one'] = $this->sel_arr($_one);
        $data['one_agent'] = $this->sel_agent_arr($_one);
        $data['two'] = $this->sel_arr($_two);
        $data['two_agent'] = $this->sel_agent_arr($_two);
        $data['three'] = $this->sel_arr($_three);
        $data['three_agent'] = $this->sel_agent_arr($_three);
        $data['four'] = $this->sel_arr($_four);
        $data['four_agent'] = $this->sel_agent_arr($_four);
        $all = array_merge($data['san'], $data['one'], $data['two'], $data['three'], $data['four']);
        $data['all'] = !empty($all) ? $all : [0];

        $all_agent = array_merge($data['one_agent'], $data['two_agent'], $data['three_agent'], $data['four_agent']);
        $data['all_agent'] = !empty($all_agent) ? $all_agent : [0];

        return $data;
    }

    /**
     * @param $san_user
     *
     */
    public function sel_arr($arr = array())
    {
        if (!empty($arr)) {
            $new_arr = [];
            foreach ($arr as $k => $val) {
                $new_arr[] = $val->user_id;
            }
            return $new_arr;
        } else {
            return [];
        }
    }

    /**
     * @param $san_user
     *
     */
    public function sel_agent_arr($arr = array())
    {
        if (!empty($arr)) {
            $new_arr = [];
            foreach ($arr as $k => $val) {
                $new_arr[] = $val->id;
            }
            return $new_arr;
        } else {
            return [];
        }
    }
}
