<?php


namespace App\Notify\SMS\Template;


use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Exceptions\ThrowException;

class SMSAdminLoginCode extends BaseSMSTemplate
{

    public $is_code = true;

    /**
     * @throws \Exception
     */
    public function config()
    {
        $this->template_id = Setting::getValueByKey('sms_login_template_id', '');
        $this->setContent([
            'type' => "管理员登陆"
        ]);
    }
}
