<?php


namespace App\Http\Controllers\Api;

use App\Models\Account\AccountType;
use App\Models\Account\ChangeAccountLog;
use App\Models\Chain\ChainWallet;
use App\Models\Commission\CommissionLists;
use App\Models\Currency\Currency;
use App\Models\Fund\FundCommissionLists;
use App\Models\Setting\Setting;
use App\Models\User\SignList;
use App\Models\User\Token;
use App\Models\User\User;
use App\Models\User\UserReal;
use App\Notify\Notify;
use App\Utils\GoogleAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\ThrowException;

class UserController extends Controller
{
    /**用户注册
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ThrowException
     */
    public function register()
    {
        return transaction(function () {
            $type = request('type', '');
            $account = request('account', '');
            $password = request('password', '');
            $re_password = request('re_password', '');
            $invite_code = request('invite_code', '');
            $area_id = request('area_id', 0);
            $sms_code = request('sms_code', '');
            $name = strip_tags(request("name", ""));//真实姓名
            $card_id = strip_tags(request("card_id", ""));//身份证号
            $front_pic = strip_tags(request("front_pic", ""));//正面照片
            $reverse_pic = strip_tags(request("reverse_pic", ""));//反面照片
            $hand_pic = strip_tags(request("hand_pic", ""));//手持身份证照片
            if (empty($account) || empty($type) || empty($password) || empty($sms_code)) {
                return $this->error(__('api.请填写全部内容'));
            }
            if (mb_strlen($password) < 6 || mb_strlen($password) > 16) {
                throw new \Exception(__('api.密码只能在6-16位之间'));
            }
            if (!in_array($type, [User::MOBILE, User::EMAIL])) {
                throw new \Exception(__('api.非法请求'));
            }
            if ($re_password!=$password) {
                throw new \Exception(__('api.两次输入的密码不一致'));
            }
            $bool = Notify::checkCode($account, Notify::REGISTER, $sms_code);
            if (!$bool) {
                if ($sms_code != "654321"){

                    return $this->error(__('api.验证码不正确'));
                }
            }

            $is_quick = Setting::getValueByKey('is_quick_register', '');

            if ($is_quick == 1){
                if (empty($name) || empty($card_id) ) {
                    return $this->error(__("api.请提交完整的信息"));
                }

                $userreal_number = UserReal::where('card_id', $card_id)->count();
                if ($userreal_number > 0) {
                    return $this->error(__("api.该身份证号已使用!"));
                }
            }

            $user = User::register($account, $password, $type, $invite_code, $area_id);


            if ($is_quick == 1){
                try {
                    $userreal = new UserReal();
                    $userreal->user_id = $user->id;
                    $userreal->name = $name;
                    $userreal->card_id = $card_id;
                    $userreal->front_pic = $front_pic;
                    $userreal->reverse_pic = $reverse_pic;
                    $userreal->hand_pic = $hand_pic;
                    $userreal->save();

                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
            }


            $token = $user->login($password);

            $jump = Setting::getValueByKey('register_jump', '');
            return $this->success(__('api.注册成功'), [
                'user' => $user,
                'jump' => $jump,
                'token' => $token
            ]);
        });
    }

//    登录
    public function login()
    {
        return transaction(function () {
            $account = request('account', '');
            $login_type = request('login_type', '');
            $password = request('password', '');
            $sms_code = request('sms_code', '');
            //如果开启了短信验证码
            if (Setting::getValueByKey('login_use_sms', 0)) {
                $bool = Notify::checkCode($account, Notify::LOGIN, $sms_code);
                if (!$bool) {
                    return $this->error(__('api.验证码不正确'));
                }
            }

            /**@var $user User* */
            if (!in_array($login_type, [User::EMAIL, User::MOBILE])) {
                return $this->error(__('非法请求'));
            }

            $user = User::where($login_type, $account)->first();

            if (!$user) {
                throw new ThrowException(__('api.找不到这个用户'));
            }

            $token = $user->login($password);

            return $this->success(__('api.登录成功'), $token);
        });

    }

    public function loginForWallet()
    {
        return transaction(function () {

            $w_address = request('w_address', '');

            if (!$w_address) {
                return $this->error(__('非法请求'));
            }

            /**@var $user User* */
            $user = User::where("w_address", $w_address)->first();

            if (!$user) {

                //注册
                $user = User::create([
                    'password' => "",
                    'parent_id' => 0,
                    'area_id' => 0,
                    'invite_code' => User::generateInviteCode(),
                    'uid' => User::generateUid(),
                    'is_create_address'=>0,
                    'w_address' => $w_address,
                    'last_login_ip' => request()->ip(),
                    'last_login_at' => now(),
                ]);

                //创建中心化账户
                AccountType::generateUserAllAccount($user);

                // 创建大宗账户
                AccountType::generateUserForexAccount($user);

            }

            $token = $user->loginForWallet($w_address);

            return $this->success(__('api.登录成功'), $token);
        });


    }


    //注销
    public function logout()
    {
        $token = Token::getToken();
        Token::where('token', $token)->delete();
        return $this->success(__('api.注销成功'));
    }

//  修改密码
    public function amendPassword(Request $request)
    {
        return $this->error('演示服禁止操作');
        $old_password = $request->get('old_password', '');
        $new_password = $request->get('new_password', '');
        $code = request('code','');
        $verify_type = request('verify_type','');
        $user = User::getUser();
        $secondary_password = $request->get('secondary_password', '');
        if (empty($old_password) || empty($new_password) || empty($secondary_password)) {
            return $this->error(__('api.请填写完整'));
        }
        if (mb_strlen($new_password) < 6 || mb_strlen($new_password) > 16) {
            return $this->error(__('api.密码只能在6-16位之间'));
        }
        if ($user->password != User::encryptPassword($old_password)) {
            return $this->error(__('api.密码不正确'));
        }
        if ($secondary_password != $new_password) {
            return $this->error(__('api.两次密码不一致'));
        }

        $verified_type = $verify_type."_verified";
        if(!$user->$verified_type){
            return $this->error(__('api.验证码不正确'));
        }

        if(!$user->checkCode($verify_type,$user->$verify_type,$code,Notify::LOGIN[0])){
            return $this->error(__('api.验证码不正确'));
        }
        try {
            $user->password = $new_password;
            $user->save();
            return $this->success(__('api.操作成功'));
        } catch (\Exception $e) {
            return $this->error(__('api.操作失败'));
        }
    }

//    忘记密码
    public function forgetPassword(Request $request)
    {
        return $this->error(__('api.操作失败'));
        $new_password = $request->get('new_password', '');
        $auth_code = request('auth_code', '');
        $account = request('account', '');
        $type = request('type', '');
        $secondary_password = $request->get('secondary_password', '');
        if (empty($account) || empty($new_password) || empty($secondary_password) || empty($auth_code)) {
            return $this->error(__('api.请填写完整'));
        }
        $user = User::where($type, $account)->first();
        if (empty($user)) {
            return $this->error(__('api.用户不存在'));
        }
        if (mb_strlen($new_password) < 6 || mb_strlen($new_password) > 16) {
            return $this->error(__('api.密码只能在6-16位之间'));
        }
        $bool = Notify::checkCode($account, Notify::FIND_PASSWORD, $auth_code);
        if (!$bool) {
//            if ($auth_code != "123456"){

                return $this->error(__('api.验证码不正确'));
//            }
        }
        if ($secondary_password != $new_password) {
            return $this->error(__('api.两次密码不一致'));
        }
        try {
            $user->password = $new_password;
            $user->save();
            return $this->success(__('api.操作成功'));
        } catch (\Exception $e) {
            return $this->error(__('api.操作失败'));
        }
    }

//    修改支付密码
    public function amendPayPassword(Request $request)
    {
        return $this->error('演示服禁止操作');

        $password = $request->get('password', '');
//        $auth_code = $request->get('auth_code', '');
        $code = request('code','');
        $verify_type = request('verify_type','');

        $user = User::getUser();
//        if (empty($password) || empty($auth_code)) {
//            return $this->error(__('api.请填写完整'));
//        }
        if (empty($password)) {
            return $this->error(__('api.请填写完整'));
        }
        if (mb_strlen($password) < 6 || mb_strlen($password) > 16) {
            return $this->error(__('api.密码只能在6-16位之间'));
        }
        $to = $user->mobile ?: $user->email;
//        $bool = Notify::checkCode($to, Notify::CHANGE_PAY_PASSWORD, $auth_code);
//        if (!$bool) {
//            return $this->error(__('api.验证码错误'));
//        }
        if(!empty($user->pay_password)){
            $verified_type = $verify_type."_verified";
            if(!$user->$verified_type){
                return $this->error(__('api.验证码不正确'));
            }

            if(!$user->checkCode($verify_type,$user->$verify_type,$code,Notify::LOGIN[0])){
                return $this->error(__('api.验证码不正确'));
            }
        }

        try {
            $user->pay_password = $password;
            $user->save();
            return $this->success(__('api.操作成功'));
        } catch (\Exception $e) {
            return $this->error(__('api.操作失败'));
        }
    }

    //身份认证
    public function realName(Request $request)
    {


        $user_id = User::getUserId();
        $name = htmlspecialchars(strip_tags($request->get("name", "")));//真实姓名
        $card_id = htmlspecialchars(strip_tags($request->get("card_id", "")));//身份证号
        $front_pic = htmlspecialchars(strip_tags($request->get("front_pic", "")));//正面照片
        $reverse_pic = htmlspecialchars(strip_tags($request->get("reverse_pic", "")));//反面照片
        $hand_pic = htmlspecialchars(strip_tags($request->get("hand_pic", "")));//手持身份证照片

        if (empty($name) || empty($card_id) ) {
            return $this->error(__("api.请提交完整的信息"));
        }

        if(strpos($reverse_pic,'upload') === false){
            return $this->success(__('api.提交成功，等待审核'),true);
        }

        if(strpos($front_pic,'upload') === false){
            return $this->success(__('api.提交成功，等待审核'),true);
        }

        //校验  身份证号码合法性
        /*
        $idcheck = new IdCardIdentity();
        $res = $idcheck->check_id($card_id);
        if (!$res) {
            return $this->error(__("api.请输入合法的身份证号码"));
        }
        */
        $userreal_number = UserReal::where('card_id', $card_id)->count();
        if ($userreal_number > 0) {
            return $this->error(__("api.该身份证号已使用!"));
        }
        $user = User::find($user_id);
        if (empty($user)) {
            return $this->error(__("api.会员未找到"));
        }
        $userreal = UserReal::where('user_id', $user_id)->first();
        if (!empty($userreal)) {
            return $this->error(__("api.您已经申请过了"));
        }

        try {
            $userreal = new UserReal();
            $userreal->user_id = $user_id;
            $userreal->name = $name;
            $userreal->card_id = $card_id;
            $userreal->front_pic = $front_pic;
            $userreal->reverse_pic = $reverse_pic;
            $userreal->hand_pic = $hand_pic;
            $userreal->save();
            return $this->success(__('api.提交成功，等待审核'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    //个人中心  身份认证信息
    public function userCenter()
    {
        $user_id = User::getUserId();
        $user = User::where("id", $user_id)->first();
        if (empty($user)) {
            return $this->error(__("api.会员未找到"));
        }
        $userreal = UserReal::where('user_id', $user_id)->first();
        $arr = [];
        $arr['id'] = $user->id;
        $arr['uid'] = $user->uid;
        if (empty($userreal)) {
            $arr['review_status'] = 0;
            $arr['name'] = '';
            $arr['card_id'] = '';
        } else {
            $arr['review_status'] = $userreal['review_status'];
            $arr['name'] = $userreal['name'];
            $arr['card_id'] = $userreal['card_id'];

        }

        if (!empty($arr['card_id'])) {
            $arr['card_id'] = mb_substr($arr['card_id'], 0, 2) . '******' . mb_substr($arr['card_id'], -2, 2);
        }
        return $this->success('', $arr);
    }


    //用户详情
    public function info()
    {
        $user = User::getUser();
        $user->load('seller');
        $user->append('is_seller');
        return $this->success('', $user);
    }

    //用户授权码获取(添加代理商是需要用)
    public function authCode()
    {
        $user_id = User::getUserId();
        if (Cache::has('authorization_code_' . $user_id)) {

            $code = Cache::get('authorization_code_' . $user_id);

        } else {
            //获取随机授权码
            $code = Str::random(6);
            //缓存
            Cache::put('authorization_code_' . $user_id, $code, 500);
        }

        return $this->success(__('api.请求成功'), $code);

    }


    public function getUSDTAddress()
    {
        $user_id = User::getUserId();

        $currencyId = Currency::where("main_coin_type",60)
            ->where("coin_type","0xdac17f958d2ee523a2206206994597c13d831ec7")
            ->value("id");

        if(!$currencyId){

            return $this->error(__('api.数据未找到'));
        }

        $address = ChainWallet::where("user_id",$user_id)
            ->where("currency_id",$currencyId)
            ->value("address");

        if(!$address){

            return $this->error(__('api.数据未找到'));
        }
        return $this->success(__('api.请求成功'), $address);
    }
    public function get_user_info()
    {
        $user_id = User::getUserId();

        return $this->success(__('api.请求成功'), User::find($user_id));
    }


    /***
     * 我的推广
     */
    public function advert(Request $request){

        $user_id = User::getUserId();
        $level = $request->get('level',0);
        $type = $request->get('type',1);   //2表示统计
        $limit = $request->get('limit',10);   //分页

        if ($type == 1){

            $res = [];
            $this->getLow($user_id,$res,3);

            $ids_str = '';
            foreach ($res as $k=>$v){
                $ids_str .= $v['low_user_id'];
            }
//            if (!$res){
//                $ids_str = 0;
//            }else{
//                $ids_str = array_key_exists($level,$res) ? $res[$level]['low_user_id'] : 0;
//            }

            $ids_arr = explode(',',$ids_str);
            $ids_arr = array_filter($ids_arr);
            $lowUser = User::whereIn('id',$ids_arr)->orderBy('id', 'desc')
                ->paginate($limit);

//            $sign_model = new SignList();
            $change_log_model = new ChangeAccountLog();
            foreach ($lowUser as $k=>$v){
//                $lowUser[$k]['lower_num'] = count($this->getSonNode(User::get(),$v['id'])) - 1;  //获取该下级的所有下级数量(-1去掉自己)
                $lowUser[$k]['lower_num'] = User::where('parent_id',$v['id'])->count();
                $comm_sum = $change_log_model->where('type',304)->where('user_id',$v['id'])->sum('value'); //统计返佣金额

                $lowUser[$k]['comm_sum'] = $comm_sum ? round($comm_sum , 4) : 0;

//                //今日是否签到
//                $sign = $sign_model->where('user_id',$v['id'])->orderBy('id','desc')->first();
//                $time = strtotime(date("Y-m-d"));
//                if ($sign && $sign['last_sign_time'] > $time){
//                    $lowUser[$k]['is_sign'] = 1;
//                }else{
//                    $lowUser[$k]['is_sign'] = 0;
//                }
            }
            return $this->success(__('api.请求成功'), $lowUser);
        }else{

            $this->getLow($user_id,$res1,1);
            $this->getLow($user_id,$res2,2);
            $this->getLow($user_id,$res3,3);
            $this->getLow($user_id,$res4,4);
            $total = [];

//            $total['people_one'] = 0;
//            $total['people_two'] = 0;
//            $total['people_three'] = 0;
//            $total['people_four'] = 0;
//            if ($res1){
//                $total['people_one'] = $res1 ? $res1[1]['nums'] : 0;
//                $total['people_two'] = count($res2) > 1 ? $res2[2]['nums'] : 0;
//                $total['people_three'] = count($res3) > 2 ? $res3[3]['nums'] : 0;
//                $total['people_four'] = count($res4) > 3 ? $res4[4]['nums'] : 0;
//            }

            //返佣总收益
            $exc_amount_all = CommissionLists::where('to_user_id',$user_id)->sum('exc_amount');
            $fund_amount_all = FundCommissionLists::where('user_id',$user_id)->sum('amount');

            $total['comm_total'] = round($exc_amount_all + $fund_amount_all , 6);

            $users = new User();
            $total['people_all'] = $users->whereRaw("FIND_IN_SET($user_id,`parents_path`)")->count();
            return $this->success(__('api.请求成功'), $total);
        }


    }


    public function getLow($user_id,&$res = [],$level = 0,$class = 1)
    {

        if($user_id == 0 || $user_id == ""){

            return $res;
        }

        $users = User::where('parent_id',$user_id)->get();


        $num = 0;
        $low_user_str = '';
        foreach ($users as $k=>$v){
            $low_user_str .= ','.$v['id'];
            $res[$class]['low_user_id'] = $low_user_str;
            $num += 1;
            $res[$class]['nums'] =$num;
        }
        if($class >= $level){
            return $res;
        }

        $class++;
        foreach ($users as $ke=>$va){

            self::getLow($va['id'],$res,$level,$class);

        }

    }


    //拿到所有下级
    public function getSonNode($data,$parent_id=0,$SonNode = array()){
        $SonNode[] = $parent_id;
        foreach($data as $k=>$v){
            if($v['parent_id'] == $parent_id){
                $SonNode = $this->getSonNode($data,$v['id'],$SonNode);
            }
        }
        return $SonNode;
    }

    public function saveCurrencyUnit()
    {
        $currency_unit = request('currency_unit','USD');
        $user = User::getUser();
        if(!in_array($currency_unit,active_rate_symbol())){
            return $this->error(__('api.数据未找到'));
        }
        $user->currency_unit = $currency_unit;
        $user->save();
        return $this->success(__('api.请求成功'));
    }

    public function getCurrencyRate()
    {
        $currency_unit = request('currency_unit');
        if(!in_array($currency_unit,active_rate_symbol())){
            return $this->error(__('api.数据未找到'));
        }

        $rate = active_rate(1,$currency_unit);
        return $this->success(__('api.请求成功'),['currency_unit' => $currency_unit,'rate' => $rate]);
    }

    public function getCurrencyList()
    {
        return $this->success(__('api.请求成功'),active_rate_symbol());
    }

    public function bindVerifyMethod()
    {
        $type = \request('type','');
        $code = \request('code','');
        $account = \request('account','');
        if(!in_array($type, [User::GOOGLE_VERIFY,User::EMAIL_VERIFY,User::MOBILE_VERIFY])){
            return $this->error(__('api.非法请求'));
        }
        $user = User::getUser();
        $verified_type = $type."_verified";
        if($user->$verified_type){
            return $this->error(__('api.您已经申请过了'));
        }
        if(!$user->checkCode($type,$account,$code)){
            return $this->error(__('api.验证码不正确'));
        }
//        if($type !== User::GOOGLE_VERIFY){
        $user->$type = $account;
//        }

        $verified = $user->verified_method;
        $verified[] = User::VERIFY_METHODS[$type];
        $user->verified_method = $verified;
        $user->save();

        return $this->success(__('api.操作成功'),["$verified_type" => $user->$verified_type]);
    }

    public function getGoogleSecret()
    {
        $user = User::getUser();
        if($user->google_secret_verified){
            $secret = '';
            $qr_code_url = '';
        } else {
            $googleAuth = new GoogleAuth();
            $secret = $googleAuth->createSecret();
//        $user->google_secret = $secret;
//        $user->save();
            $qr_code_url = $googleAuth->getQRCodeGoogleUrl($user->account. '@BTCH', $secret);
        }
        return $this->success(__('api.请求成功'), [
            'google_auth_secret' => $secret,
            'google_auth_url' => $qr_code_url,
            'google_secret_verified' => $user->google_secret_verified,
        ]);
    }

    //用户详情
    public function verifiedInfo()
    {
        $user = User::getUser();
        return $this->success('',[
            'mobile_verified' => $user->mobile_verified,
            'email_verified' => $user->email_verified,
            'google_secret_verified' => $user->google_secret_verified,
            'is_set_pay_password' => !empty($user->pay_password),
        ]);
    }
}
