<?php


namespace App\Notify\Email\Template;


use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Exceptions\ThrowException;
use App\Notify\Email\SendCloudEmail;

class EmailAdminLoginCode extends BaseEmailTemplate
{

    public $is_code = true;

    /**
     * @throws \Exception
     */
    public function config()
    {
        $this->subject = "管理员登陆";

        if(Setting::getValueByKey('send_email_tmp_type', '') == 1){//use template html

            $this->template_id = $this->baseTmp;
        }else{
            $this->template_id = SendCloudEmail::getTransTmpId();
//            $this->template_id = Setting::getValueByKey('email_login_template_id', '');
        }
        $this->setContent([
            'type' => "管理员登陆"
        ]);

    }
}
