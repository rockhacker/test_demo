<?php


namespace App\Notify\Email;

use App\Exceptions\ThrowException;
use App\Models\Setting\Setting;
use App\Notify\Notify;
use App\Notify\NotifyTemplate;

class ModuyunEmail extends Notify
{

    const STATUS_OK = 0;

    protected function config()
    {
        $this->send_type = self::EMAIL_DRIVER;
        $this->config['email_appid'] = Setting::getValueByKey('email_appid');
        $this->config['email_appkey'] = Setting::getValueByKey('email_appkey');
        $this->config['from_email'] = Setting::getValueByKey('mdy_from_email');
        $this->config['from_alias'] = Setting::getValueByKey('from_alias');
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
        $secretkey = $this->config['email_appkey'];
        $url = $this->getGatewayUrl($this->area->global_code);
        $sign = hash(
            "sha256",
            "secretkey={$secretkey}&random={$random}&time={$now}&fromEmail={$this->config['from_email']}",
            false
        );
        $subject = $this->template->subject ?? '';
        $content = NotifyTemplate::strReplace($this->template->template_id, $this->buildVars());
        $body = [
            'sig' => $sign,
            'time' => $now,
            'type' => 0,
            'fromEmail' => $this->config['from_email'],
            'needToReply' => false,
            'replyEmail' => '',
            'clickTrace' => '0',
            'readTrace' => '0',
            'fromAlias' => $this->config['from_alias'],
            'ext' => '',
            'toEmail' => $to,
            'subject' => $subject,
            'htmlBody' => $content,
        ];

        $result = raw_http($url, json_encode($body), [
            'accesskey' => $this->config['email_appid'],
            'random' => $random,
        ], [
            'Content-Type' => 'application/json',
        ]);

        throw_if(
            !isset($result['result']) || $result['result'] != self::STATUS_OK,
            new \Exception($result['errmsg'] ?? "未知错误")
        );
    }

    public function buildVars()
    {
        $var = $this->template->content;
        return $var;
    }

    protected function getGatewayUrl($global_code = 86)
    {
        return 'https://live.moduyun.com/directmail/v1/singleSendMail';
    }
}
