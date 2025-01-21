<?php

namespace App\Models\QuickCharge;

use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyRate;
use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RechargeOrder extends Model
{

    protected $appends = [
        "email"
    ];


    public function getEmailAttribute()
    {
        return $this->getUsers->email ?? __('model.未知');
    }

    public function getUsers(): BelongsTo
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function getRate(): BelongsTo
    {
        return $this->belongsTo(CurrencyRate::class,"currency_rate_id","id");
    }


    public static function toPay($amount,$order_no){
        $url = "https://vn2zfapi.shion.vip/payment/vnd/create";
        $config = [
            'mch_id'=>'M1001654693',
            'mch_key'=>'ibnpdaebfdspcepwco',
            'notify_url'=>'https://api.btcthree.com/api/notify/weiNotify',
        ];
        $key = $config['mch_key'];
        $param = [
            'merchantNo' => $config['mch_id'],
            'type' => 'bankqrcode',
            'amount' => $amount,
            'outTradeNo' => $order_no,
            'notifyUrl' => $config['notify_url'],

        ];
        $str = "amount=".$param['amount']."&merchantNo=".$param['merchantNo']."&notifyUrl=".$param['notifyUrl']."&outTradeNo=".$param['outTradeNo']."&type=".$param['type']."&signKey=".$key;
        $sign = strtoupper(md5($str));
//        $ch = curl_init();
        $param['sign'] = $sign;
//        $html = '<form name="MerOrder" id="MerOrder" method="post" action="'.$url.'">
//						<input type="hidden" name="merchantNo" value="'.$param['merchantNo'].'"/>
//						<input type="hidden" name="outTradeNo" value="'.$param['outTradeNo'].'"/>
//						<input type="hidden" name="amount" value="'.$param['amount'].'"/>
//						<input type="hidden" name="type" value="'.$param['type'].'"/>
//						<input type="hidden" name="notifyUrl" value="'.$param['notifyUrl'].'"/>
//						<input type="hidden" name="sign" value="'.$sign.'"/>
//					</form>';
//        if($html){
//            return ['status'=>2,'url'=>$html];
//        }else{
//            return ['status'=>1,'url'=>""];
//        }
        $info = self::curl_post($param);
        return $info;
    }

    public static function curl_post($data){

        $headers = array(
            'Content-Type: multipart/form-data'
        );
        $url = "https://vn2zfapi.shion.vip/payment/vnd/create";
//        $data = json_encode($data);
        $curl = curl_init();
        //请求地址
        curl_setopt($curl, CURLOPT_URL, $url);
        //头部验证
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //头部验证
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //是否返回结果
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //请求超时设置（单位秒，0不做限制）
//    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10000);
        //https请求，（false为https）
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //请求方式POST
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        //参数设置
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行
        $response = curl_exec($curl);
        //关闭
        curl_close($curl);

        return $response;
    }


    public function updateOrder($outTradeNo,$amount,$sn){

        $reOrder = $this->where('order_no',$outTradeNo)->first();
        if (!$reOrder){
            $this->paylog("未找到订单号为: ".$outTradeNo . " 的订单");
        }
        if ($reOrder['status'] == 2){
            $this->paylog("订单号为: ".$outTradeNo . " 的订单已回调，请勿重复回调");
            return false;
        }
        $currency_rate = CurrencyRate::where('id',$reOrder['currency_rate_id'])->first();
        $data = [
            'status'=>2,
            'platform_no'=>$sn,
            'exch_usdt_num'=>round($reOrder['amount'] * $currency_rate['rate'] , 8),
            'updated_at'=>date("Y-m-d H:i:s")
        ];
        $res = $this->where('id',$reOrder['id'])->update($data);

        if (!$res){
            $log = [];
            $log['rechargeStatus'] = $res;
            $log['time'] = date('Y-m-d H:i:s',time());
            $log['msg'] = '回调更新状态失败';
            file_put_contents('./logs/updateOrder_'.date('Y-m-d',time()) . '.log',"[".date("Y-m-d H:i:s")."]" .$log . PHP_EOL,FILE_APPEND);
            return false;
        }

        return true;
    }


    private function paylog($info){

        file_put_contents("./logs/pay_log".date("Y-m-d").".log",date("Y-m-d H:i:s")   .$info . "\r\n ",FILE_APPEND);

    }
}
