<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\UserSaveRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Logic\User as UserLogic;
use App\Models\Agent\Agent;
use App\Models\Lever\LeverTransaction;
use App\Models\System\Area;
use App\Models\Tx\TxHistory;
use App\Models\User\Token;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function list()
    {
        $uid = request('uid', '');
        $mobile = request('mobile', '');
        $email = request('email', '');
        $start_time = request('start_time', '');
        $over_time = request('over_time', '');
        $limit = request('limit', 10);

        $list = User::when($start_time, function ($query) use ($start_time) {
            $query->where('created_at', '>=', $start_time);
        })->when($over_time, function ($query) use ($over_time) {
            $query->where('created_at', '<=', $over_time);
        })->when($uid, function ($query) use ($uid) {
            $query->where('uid', $uid);
        })->when($mobile, function ($query) use ($mobile) {
            $query->where('mobile', $mobile);
        })->when($email, function ($query) use ($email) {
            $query->where('email', $email);
        })->orderBy('id', 'DESC')->paginate($limit);

        $list->getCollection()->each(function ($user) {
            $user->append('status_name');
            $user->append('parent_email');
            return $user;
        });

        return $this->layuiPageData($list);
    }

    public function add()
    {
        $arr = Area::all();
        return view('admin.user.add', ['areas' => $arr]);
    }

    public function save(UserSaveRequest $request)
    {
        return transaction(function () use ($request) {
            $data = $request->validated();

            $account = $data['account'];
            $password = $data['password'];
            $register_type = $data['type'];
            $invite_code = $data['invite_code'];
            $area_id = $data['area_id'];

            User::register($account, $password, $register_type, $invite_code, $area_id);

            return $this->success('操作成功');
        });
    }

    public function edit(Request $request)
    {
        $user_id = $request->get('user_id', 0);
        $user = User::findOrFail($user_id);

        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        try {
            $user_id = $request->get('user_id', 0);
            $password = $request->get('password', "");
            $pay_password = $request->get('pay_password', "");
            $status = $request->get('status', User::UNLOCK);
            $tx_status = $request->get('tx_status', User::UNLOCK);
            $operateId = $request->get("operate_id",0);//邀请码
            $micro_cont_status = $request->get("micro_cont_status",0);//
            $micro_risk_profit_probability = $request->get("micro_risk_profit_probability",0);//
            $credit_score = $request->get("credit_score",0);//
            $level = $request->get("level","");
            $user = User::where('id', $user_id)->firstOrFail();

            if ($password) {
                return $this->error('演示服禁止修改密码');

                $user->password = $password;
            }
            if ($pay_password) {
                $user->pay_password = $pay_password;
            }
            if ($status == User::LOCK) {
                Token::where('user_id', $user_id)->delete();
            }
            $user->status = $status;
            $user->tx_status = $tx_status;
            $user->micro_cont_status = $micro_cont_status;
            $user->micro_risk_profit_probability = $micro_risk_profit_probability;
            $user->credit_score = $credit_score;
            $user->level = $level;

            if($operateId){

                if($user->invite_code == $operateId){

                    return $this->error('不能对用户设置自己为上级');
                }

                $agent = User::where('invite_code', $operateId)->first();

                if(!$agent){

                    return $this->error('搜索不到该代理');
                }

                $exists = User::where("id",$user_id)->first();

                if (!empty($exists->parent_id)){

                    return $this->error('该用户已有上级，无法修改');
                }
                $user = User::find($user_id);

                $user->parent_id = $agent->id;
                //创建上级路径
                $user->parents_path = UserLogic::getRealParentsPath($user);
                //寻找上级代理商id
                $user->agent_node_id = Agent::getAgentIdByParentId($agent->id);
                //代理商路径
                $user->agent_path = Agent::agentPath($agent->id);

            }

            $user->save();
            return $this->success('操作成功');
        } catch (\Exception $e) {
            return $this->error('操作失败');
        }

    }

    public function delete()
    {
        return $this->error('为了系统稳定不允许删除');
    }
}
