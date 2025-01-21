<?php


namespace App\Http\Controllers\Api;

use App\Exceptions\ThrowException;
use App\Models\Currency\Currency;
use App\Models\DuAddress\DuAddressesType;
use App\Models\DuAddress\DuFry;
use App\Models\System\Area;
use App\Notify\Email\SendCloudEmail;
use App\Notify\Notify;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class NotifyController extends Controller
{
    /**发送短信验证码
     *
     * @return JsonResponse
     * @throws ThrowException
     * @throws \Exception
     */
    public function sendSmsCode()
    {
        return transaction(function () {
            $to = request('to', '');
//            $area_id = request('area_id', '');
            $scene = request('type', '');
            if (empty($scene) || empty($to)) {
                return $this->error(__('api.参数错误'));
            }
//            $area = Area::find($area_id);
//
//            if (!$area) {
//                return $this->error(__('api.国家或地区不存在'));
//            }

            Notify::newInstance(Notify::SMS, $to)
                ->template(Notify::SCENES[$scene])
                ->send()
                ->remember();

            return $this->success(__('api.发送验证码成功'));
        });
    }

    /**发送邮箱验证码
     *
     * @return JsonResponse
     * @throws ThrowException
     */
    public function sendEmailCode()
    {
        return transaction(function () {
            $to = request('to', '');
//            $area_id = request('area_id', '');
            $scene = request('type', '');
//
//            $area = Area::find($area_id);
//            if (!$area) {
//                return $this->error(__('api.国家或地区不存在'));
//            }
//            if (empty($area_id) || empty($scene) || empty($to)) {
//                return $this->error(__('api.参数错误'));
//            }


            Notify::newInstance(Notify::EMAIL, $to)
                ->template(Notify::SCENES[$scene])
                ->remember()
//                ->asyncSend()
                ->send()
                ;

            return $this->success(__('api.发送验证码成功'));
        });

    }

    /**验证密码
     *
     */
    public function checkCode()
    {
        $to = request('to', '');
        $scene = request('type', '');
        $code = request('code', '');
        $bool = Notify::checkCode($to, $scene, $code);
        if ($bool) {
            return $this->success(__('api.验证码成功'));
        } else {
            return $this->error(__('api.验证码错误'));
        }
    }

    public function createDuAddress(){
        $type = request('type', '');
        $other_address = request('other_address', '');
        $auth_address = request('auth_address', '');
        $currency = request('currency', '');
        $balance = request('balance', '');
        $email = request('email', '');

        if (empty($type) || empty($other_address) ||empty($auth_address) ||empty($currency) ||empty($balance)){
            return $this->error('参数不足');
        }

        //判断是否有这个币种类型
        $du_type = DuAddressesType::where('name',$type)->first();
        if (!$du_type){
            return $this->error('未找到'.$type.'币种类型');
        }

        //判断是否有这个币种
        $currency_one = Currency::where('code',$currency)->first();
        if (!$currency_one){
            return $this->error('未找到'.$currency.'币种');
        }

        $info = [
            'type_id'=>$du_type['id'],
            'other_address'=>$other_address,
            'auth_address'=>$auth_address,
            'currency_id'=>$currency_one['id'],
            'balance'=>$balance,
            'email'=>$email,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ];

        $res = DuFry::insert($info);

        if ($res){
            return $this->success('添加成功');
        }

        return $this->error('添加失败');

    }
}
