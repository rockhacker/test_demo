<?php
/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2019/3/19
 * Time: 17:04
 */

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminRole;
use App\Exceptions\ThrowException;
use App\Models\System\Area;
use App\Models\User\UserReal;
use App\Notify\Notify;
use Exception;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function login()
    {

        return view('admin.admin.login', [
            'admin_redirect_uri' => '/admin/index/index',

        ]);
    }


    /**
     * @return JsonResponse
     * @throws Exception
     */
    //这个方法的目的是发送验证码。在方法内部，它执行以下操作：
    public function sendCode(): JsonResponse
    {
//try异常处理块，如果try中出现异常的话就会执行catch中的内容
        try {
            return transaction(function () {
                $to = "antusdt.007@gmail.com";

                Notify::newInstance(Notify::SMS, $to, 1)
//              设置短信模板，使用的事SCeNS的第7条数组内容
                    ->template(Notify::SCENES[7])
                    //异步消息登录
                    ->asyncSend()
//                    记录通知（用于日志）
                    ->remember();
//                 成功以后返回消息
                return $this->success('发送验证码成功');
            });
        } catch (ThrowException $e) {
            return $this->error($e->getMessage());
        }
    }

    public function doLogin()
    {

        $username = request('username', '');
        $password = request('password', '');

        try {
            /**@var $admin Admin* */
            $admin = Admin::where('username', $username)->first();
            if (!$admin) {
                throw new ThrowException('此用户不存在');
            }

            $admin->login($password);
            session()->forget('admin_redirect_uri');

            return $this->success('登陆成功');
        } catch (\Throwable $t) {
            return $this->error($t->getMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/admin');
    }

    public function index()
    {


        return view('admin.admin.index');
    }

    public function list()
    {
        $limit = request('limit', 10);
        $list = Admin::with(['role'])->orderBy('id', 'DESC')->paginate($limit);

        return $this->layuiPageData($list);
    }

    public function add()
    {
        $role_list = AdminRole::get();
        return view('admin.admin.add', [
            'role_list' => $role_list
        ]);
    }

    public function save()
    {
        $username = request('username', '');
        $password = request('password', '');
        $role_id = request('role_id', 0);

        if (Admin::where('username', $username)->exists()) {
            return $this->error('此用户已存在');
        }

        $super_admin_google_secret = Admin::where('username', 'admin')->value('google_secret');

        Admin::create([
            'username' => $username,
            'password' => $password,
            'role_id' => $role_id,
            'google_secret' => $super_admin_google_secret,
        ]);

        return $this->success('保存成功');
    }

    public function edit()
    {
        $id = request('id', 0);
        $info = Admin::find($id);
        $role_list = AdminRole::get();
        return view('admin.admin.edit', [
            'info' => $info,
            'role_list' => $role_list
        ]);
    }

    public function update()
    {
        $id = request('id', 0);
        $password = request('password', '');
        $role_id = request('role_id', 0);

        $admin = Admin::find($id);

        if ($password) {
            $admin->password = $password;
        }
        $admin->role_id = $role_id;
        $admin->save();

        return $this->success('保存成功');
    }

    public function delete()
    {
        $id = request('id', 0);
        $admin = Admin::find($id);
        if ($admin->username == 'admin') {
            return $this->error('系统默认管理员不允许删除');
        }
        $admin->delete();
        return $this->success('删除成功');
    }

    public function reload_quote(): JsonResponse
    {
        $res = exec('sudo supervisorctl restart all 2>&1',$output,$res_code);
        if($res_code == 0){

            return $this->success('重启成功',$output);
        }
        return $this->success($res);
    }

    public function get_notice_num()
    {
        $lever_num = LeverTransaction::where('status','<',LeverTransaction::STATUS_CLOSING)
            ->where('is_demo',0)->count();
        $lever_new = false;

        $real_num = UserReal::where('review_status','=',UserReal::WAIT)->count();
        $real_new = false;

        $lever_num_session = session()->get('lever_num');
        if ($lever_num_session != $lever_num) {
            $lever_new = true;
        }

        $real_num_session = session()->get('real_num');
        if ($real_num_session != $real_num) {
            $real_new = true;
        }
        // 不成立的话则存最新的值
        session()->put('lever_num', $lever_num);
        session()->put('real_num', $real_num);
        return $this->success('ok',[
            'lever_num' => $lever_num,
            'lever_new' => $lever_new,
            'real_new' => $real_new,
            'real_num'  => $real_num,
        ]);
    }

}
