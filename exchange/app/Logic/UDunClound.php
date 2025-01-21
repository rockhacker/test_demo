<?php


namespace App\Logic;


class UDunClound
{
    private static $gateway_address = "https://hk01-node.uduncloud.com11";
    private static $api_key = "2f082f3456886844a872eeab82a3647311";
    private static $merchant_number = "30739111";
    private static $walletId = "WT_307391_0001";
    // 获取商户支持的币种信息
    public static function supportCoins($showBalance = true)
    {
        $body = array(
            'merchantId'  => self::$merchant_number,
            'showBalance' => $showBalance
        );

        $body      = json_encode($body);
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/support-coins';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }
    // 校验地址合法性
    public static function existAddress($mainCoinType, $address)
    {
        $body = array(
            'merchantId'   => self::$merchant_number,
            'mainCoinType' => $mainCoinType,
            'address'      => $address,
        );

        $body      = '[' . json_encode($body) . ']';
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/exist/address';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }

    // 生成地址
    public static function createAddress($coinType, $callUrl)
    {
        $body = array(
            'merchantId' => self::$merchant_number,
            'coinType'   => $coinType,
            'callUrl'    => $callUrl,
            'walletId'   => self::$walletId
        );

        $body      = '[' . json_encode($body) . ']';
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/address/create';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }

    // 校验地址合法性
    public static function checkAddress($mainCoinType, $address)
    {
        $body = array(
            'merchantId'   => self::$merchant_number,
            'mainCoinType' => $mainCoinType,
            'address'      => $address,
        );

        $body      = '[' . json_encode($body) . ']';
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/check/address';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }

    // 发送提币申请
    public static function withdraw($mainCoinType, $coinType, $amount, $address, $callUrl, $businessId, $memo = "")
    {
        $body = array(
            'merchantId'   => self::$merchant_number,
            'mainCoinType' => $mainCoinType,
            'address'      => $address,
            'amount'       => $amount,
            'coinType'     => $coinType,
            'callUrl'      => $callUrl,
            'businessId'   => $businessId,
            'memo'         => $memo
        );

        $body      = '[' . json_encode($body) . ']';
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/withdraw';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }

    //代付
    public static function proxyPay($mainCoinType, $coinType, $amount, $address, $callUrl, $businessId, $memo = "")
    {
        $body = array(
            'merchantId'   => self::$merchant_number,
            'mainCoinType' => $mainCoinType,
            'address'      => $address,
            'amount'       => $amount,
            'coinType'     => $coinType,
            'callUrl'      => $callUrl,
            'businessId'   => $businessId,
            'memo'         => $memo
        );

        $body      = '[' . json_encode($body) . ']';
        $timestamp = time();
        $nonce     = rand(100000, 999999);

        $url = self::$gateway_address . '/mch/withdraw/proxypay';
        $key = self::$api_key;

        $sign = md5($body . $key . $nonce . $timestamp);

        $data = array(
            'timestamp' => $timestamp,
            'nonce'     => $nonce,
            'sign'      => $sign,
            'body'      => $body
        );

        $data_string = json_encode($data);

        return self::http_post($url, $data_string);
    }

    public static function callBack()
    {
        $input = Request()->input();
        file_put_contents(public_path("/call_back_data.txt"), "\n" . date('Y-m-d H:i:s') . json_encode($input, 320) . "\n", FILE_APPEND);

        if (empty($input['timestamp']) || !$input['nonce'] || !$input['sign'] || !$input['body']) {

            file_put_contents(public_path("/call_back_data.txt"), "\n" . date('Y-m-d H:i:s') . "缺少参数：" . json_encode($input, 320), FILE_APPEND);
            return ['code' => 0, 'msg' => "无法读取参数", 'data' => null];
        }

        $call_back_data = array(
            'timestamp' => (string)$input['timestamp'],
            'nonce'     => (string)$input['nonce'],
            'sign'      => (string)$input['sign'],
            'body'      => (string)$input['body'],
        );

        $sign = md5($call_back_data['body'] . self::$api_key . $call_back_data['nonce'] . $call_back_data['timestamp']);

        if ($call_back_data['sign'] == $sign) {

            $body = json_decode($call_back_data['body'], true);

            // $body['tradeType'] //1充币回调 2提币回调
            // $body['status'] //0待审核 1审核成功 2审核驳回 3交易成功 4交易失败

            return ['code' => 1, 'msg' => "成功", 'data' => $body];
        } else {

            file_put_contents(public_path("/call_back_data.txt"), "\n" . date('Y-m-d H:i:s') . "\n sign error: \n" . $sign . "\n" . $call_back_data['sign'] . "\n", FILE_APPEND);
            return ['code' => 0, 'msg' => "sign解密失败", 'data' => null];
        }
    }

    private static function http_post($url, $data_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-AjaxPro-Method:ShowList',
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }
}
