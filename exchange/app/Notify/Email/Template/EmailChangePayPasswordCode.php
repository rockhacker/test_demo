<?php


namespace App\Notify\Email\Template;


use App\Models\Setting\Setting;
use App\Notify\Email\SendCloudEmail;
use App\Notify\Notify;

class EmailChangePayPasswordCode extends BaseEmailTemplate
{

    public $is_code = true;

    public function config()
    {
        $this->subject = __("notify.修改支付密码验证码");
        $this->setContent([
            'type' => __('notify.找回支付密码')
        ]);
        if(Setting::getValueByKey('send_email_tmp_type', '') == 1){//use template html

            $this->template_id = $this->baseTmp;
        }else{
            $this->template_id = SendCloudEmail::getTransTmpId();
//            $this->template_id = Setting::getValueByKey('email_change_paypassword_template_id', '');
        }
    }
}
