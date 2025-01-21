<?php


namespace App\Notify\Email\Template;


use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Notify\Email\SendCloudEmail;
use App\Notify\Notify;
use App\Exceptions\ThrowException;

class EmailWithdrawCode extends BaseEmailTemplate
{

    public $is_code = true;

    public function config()
    {
        $this->subject =  __("notify.申请提币验证码");
        $this->setContent([
//            'type' => __('notify.申请提币')
            'type' => "貨幣の引き出しを申請する"
        ]);
        if(Setting::getValueByKey('send_email_tmp_type', '') == 1){//use template html

            $this->template_id = $this->baseTmp;
        }else{
            $this->template_id = SendCloudEmail::getTransTmpId();
//            $this->template_id = Setting::getValueByKey('email_withdraw_template_id', '');
        }

        $user = User::where('email', $this->notify->to)->exists();
        if (!$user) {
            throw new ThrowException(__('notify.用户不存在'));
        }
    }
}
