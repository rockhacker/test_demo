<?php


namespace App\Notify\Email;


use App\Exceptions\ThrowException;
use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Notify\Notify;

class SendCloudEmail extends Notify
{
    public function config()
    {
        $this->send_type = self::EMAIL_DRIVER;
        $this->config['sendCloud_mail_apiuser'] = Setting::getValueByKey('sendCloud_mail_apiuser');
        $this->config['sendCloud_mail_apikey'] = Setting::getValueByKey('sendCloud_mail_apikey');
        $this->config['from'] = Setting::getValueByKey('from_email');
        $this->config['from_alias'] = Setting::getValueByKey('from_alias');
    }

    public function send()
    {
        $url = 'https://api.sendcloud.net/apiv2/mail/sendtemplate';

        $keys = array_keys($this->template->content);
        $vars = [];
        foreach ($keys as $key){

            $vars['%'.$key. '%'] = [$this->template->content[$key]];
        }
        $xsmtpapi = json_encode(['to' => [$this->to],'sub' => $vars]);
        $result = http($url, [
            'apiUser' => $this->config['sendCloud_mail_apiuser'],
            'apiKey' => $this->config['sendCloud_mail_apikey'],
            'from' => $this->config['from'],
            'fromName' => $this->config['from_alias'],
            'to' => $this->to,
            'xsmtpapi' => $xsmtpapi,
            'templateInvokeName' => $this->template->template_id,
        ], 'POST');

        if ($result['statusCode'] != 200) {

            throw new ThrowException($result['message']);
        }
    }

    /**
     * @return string
     */
    public static function getTransTmpId(): string
    {
        $lang = request()->header("lang") ?? "en";

        switch ($lang){
            case "zh":
            case "hk":
            case "en":
                return "verificationcode";
            default :
                return "verificationcode_".$lang;
        }
    }
}
