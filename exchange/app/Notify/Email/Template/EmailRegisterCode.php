<?php


namespace App\Notify\Email\Template;

use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Notify\Email\SendCloudEmail;
use App\Notify\Notify;
use App\Exceptions\ThrowException;

class EmailRegisterCode extends BaseEmailTemplate
{

    public $is_code = true;

    /**
     * @throws \Exception
     */
    public function config()
    {
        $this->subject = __("notify.注册验证码");
        $this->setContent([
            'type' => __('notify.注册')
//            'type' => "登録済み"
        ]);
        if(Setting::getValueByKey('send_email_tmp_type', '') == 1){//use template html

            $this->template_id = $this->LangeTmp();
        }else{
            $this->template_id = SendCloudEmail::getTransTmpId();
//            $this->template_id = Setting::getValueByKey('email_register_template_id', '');
        }

        $exists = User::where('email', $this->notify->to)->exists();
        if ($exists) {
            throw new ThrowException(__('notify.用户已注册'));
        }
    }
}
