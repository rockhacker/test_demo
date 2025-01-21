<?php


namespace App\Notify\SMS;

use App\Exceptions\ThrowException;
use App\Models\Setting\Setting;
use App\Notify\Notify;

class ModuyunSMS extends Notify
{

    const STATUS_OK = 0;

    protected function config()
    {
        $this->send_type = self::SMS_DRIVER;
        $this->config['domestic_sms_appid'] = Setting::getValueByKey('domestic_sms_appid');
        $this->config['domestic_sms_appkey'] = Setting::getValueByKey('domestic_sms_appkey');
        $this->config['sms_sign'] = Setting::getValueByKey('sms_sign');
    }

    /**
     * @param $to
     * @param $content
     *
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public function send()
    {
        $to = $this->to;
        $random = rand(10000, 99999);
        $now = time();
        $secretkey = $this->config['domestic_sms_appkey'];
        $sign = hash(
            "sha256",
            "secretkey={$secretkey}&random={$random}&time={$now}&mobile={$to}",
            false
        );
        $tel = [
            'nationcode' => strval($this->area->global_code),
            'mobile' => strval($to),
        ];
        $params = $this->buildVars();
        $body = [
            'sig' => $sign,
            'signId' => $this->config['sms_sign'],
            'templateId' => $this->template->template_id,
            'time' => $now,
            'type' => 0,
            'tel' => $tel,
            'params' => array_values($params),
            'ext' => '',
        ];
        $url = $this->getGatewayUrl($this->area->global_code);
        $result = raw_http($url, json_encode($body), [
            'accesskey' => $this->config['domestic_sms_appid'],
            'random' => $random,
        ], [
            'Content-Type' => 'application/json',
        ]);
        throw_if(
            !isset($result['result']) || $result['result'] != self::STATUS_OK,
            new ThrowException($result['errmsg'] ?? "未知错误")
        );
    }

    public function buildVars()
    {
        $var = $this->template->content;
        return [$var['code']];
    }

    protected function getGatewayUrl($global_code = 86)
    {
        return 'https://live.moduyun.com/sms/v2/sendsinglesms';
    }
}
