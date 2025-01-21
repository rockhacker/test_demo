<?php
/**
 * create by vscode
 *
 * @author lion
 */

namespace App\Models\DuAddress;

use App\Models\Model;
use App\Models\System\Lang;

class DuFry extends Model
{


    /**
     * @param $address
     * @param $type
     * @return array
     */
    public function getBalance($address,$type): array
    {

        $info = ['code'=>0 , 'msg'=>'' , 'balance'=>''];
        if ($type == 'trc'){
            $url = env('WEB3_URL').'/tron/conBalance?address='.$address;

        }else{
            $url = env('WEB3_URL').'/eth/conBalance?address='.$address;
        }
        $data = $this->curl($url);

        $data = json_decode($data,true);
        if (!$data || !$data['success']){
            $info['msg'] = '查询不到该地址';
            return $info;
        }
        $balance = $data['balance'];



        $info['code'] = 1;
        $info['balance'] = $balance;
        return $info;
    }

    /**
     * @param $fromAdd
     * @param $privatekey
     * @param $toAdd
     * @param $num
     * @param $type
     * @return array
     */
    public function transfer($fromAdd,$privatekey,$toAdd,$num,$type): array
    {
        $info = ['code'=>0 , 'msg'=>'发送链上交易失败，请重试' , 'hash'=>''];
        if ($type == 'trc'){

            $url = env('WEB3_URL')."/tron/conTran?fromAdd={$fromAdd}&privatekey={$privatekey}&num={$num}&toAdd={$toAdd}";
        }else{

            $url = env('WEB3_URL')."/eth/conTran?fromAdd={$fromAdd}&privatekey={$privatekey}&num={$num}&toAdd={$toAdd}&limit=87904";
        }
        try{

            $data = json_decode($this->curl($url),true);

        }catch(\Exception $exception){

            $info['code'] = 1;
            $info['msg'] = "区块网络拥挤，发送交易时间过长，请链上查看地址确认是否存在发送的订单";
            $info['hash'] = "";
            $data = [];
        }

        if($data){

            $hash = !empty($data['hash']) ? $data['hash'] : "";

            if($data['success']) {

                $info['code'] = 1;
                $info['hash'] = $hash;
            }
        }

        return $info;
    }


    /**
     * @param $url
     * @param $postdata
     * @return bool|string
     */
    public function curl($url, $postdata = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36",
            "Accept-Language:zh-cn",
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT,5);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $output;
    }
}
