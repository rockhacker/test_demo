<?php


namespace App\Notify\SMS;


use App\Exceptions\ThrowException;
use App\Models\Setting\Setting;
use App\Notify\Notify;

class SendCloundSMS extends Notify
{
    public function send()
    {
        $content = $this->buildVars();
//
        $to = $this->to;
//        $url = $this->getGatewayUrl($this->area->global_code);
//        $appid = $this->config['domestic_sms_apiuser'];
//        $appkey = $this->config['domestic_sms_apikey'];
//        $params = [
//            'smsUser' => $appid,
//            'phone' => $to,
//            'msgType' => 0,
//            'templateId' => $this->template->template_id,
//            'signName' => 'crm',
////            'vars' => json_encode($content,1),
//            'code' => $content,
//        ];
//        $params['signature'] = $this->sign($appkey, $params);
//        $result = http($url, $params, 'POST');
//        $status_arr = [
//            "200" => '请求成功',
//            '311' => '部分号码请求成功',
//            '312' => '全部请求失败',
//            '411' => '手机号不能为空',
//            '412' => '手机号格式错误',
//            '413' => '有重复的手机号',
//            '416' => 'tag格式错误',
//            '417' => 'tag长度不能超过128个字符',
//            '421' => '数字签名参数错误',
//            '422' => '数字签名错误',
//            '431' => '模板不存在',
//            '432' => '模板未提交审核或者未审核通过',
//            '433' => '模板ID不能为空',
//            '441' => '替换变量格式错误',
//            '451' => '定时发送时间的格式错误',
//            '452' => '定时发送时间早于服务器时间, 时间已过去',
//            '461' => '时间戳无效, 与服务器时间间隔大于6秒',
//            '471' => 'smsUser不存在',
//            '472' => 'smsUser不能为空',
//            '473' => '没有权限, 免费用户不能发送短信',
//            '474' => '用户不存在',
//            '481' => '手机号和替换变量不能为空',
//            '482' => '手机号和替换变量格式错误',
//            '483' => '替换变量长度不能超过16或32个字符',
//            '499' => '账户额度不够',
//            '501' => '服务器异常',
//            '601' => '你没有权限访问',
//            '50000' =>'接口频率受限(每个smsUser,每个接口、每分钟调用4000次，目前只限制投递回应)',
//        ];
//        var_dump($result);
//        exit;
//        if ($result['statusCode'] != 200) {
//            throw new ThrowException($status_arr[$result['statusCode']]);
//        }

        $rp = http("http://api.wftqm.com/api/sms/mtsend",[
            'appkey'=>'cTddqGY8',
            'secretkey'=>'9DrAjpcJ',
            'phone'=>$to,
            'content'=>"Meta universe global digital currency trading platform, your verification code is : {$content}",
        ],"POST",[
            'Content-Type'=>'application/x-www-form-urlencoded'
        ]);

        return $this;
    }

    public function config()
    {
        $this->send_type = self::SMS_DRIVER;
        $this->config['domestic_sms_apiuser'] = Setting::getValueByKey('SendClound_sms_api_user');
        $this->config['domestic_sms_apikey'] = Setting::getValueByKey('sendClound_sms_api_key');
    }

    public function buildVars()
    {
        $var = $this->template->content;
        return $var['code'];
    }

    protected function getGatewayUrl($global_code = 86)
    {
        return 'http://www.sendcloud.net/smsapi/sendCode';
    }

    protected function sign(string $apiKey, array $params)
    {
        ksort($params);
        $signParts = [$apiKey, $apiKey];
        foreach ($params as $key => $value) {
            array_splice($signParts, -1, 0, $key.'='.$value);
        }

        return md5(join('&', $signParts));
    }
}
