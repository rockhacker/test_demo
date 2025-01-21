<?php


namespace App\BlockChain;


use App\Exceptions\ThrowException;
use App\Logic\UDunClound;
use GuzzleHttp\Exception\GuzzleException;
use mysql_xdevapi\Exception;

class BCH extends BlockChain
{
    protected $wallet;


    protected $currency_code = 145;
//    protected $address_attribute = 'bch_address';
    protected $private_attribute = 'bch_private';

    protected static function api()
    {
        $parent_api = parent::api();
        $api = [
            'transfer' => '$HOST/v3/wallet/bch/sendto',
            'balance' => '$HOST/wallet/bch/balance',
            'txStatus' => '$HOST/wallet/bch/tx',
        ];
        return array_merge($api, $parent_api);
    }

    public $recharge_method = self::API_METHOD;

    /**
     * 刷新余额
     *
     * @param $address
     *
     * @return bool|float|string|null
     * @throws GuzzleException
     * @throws ThrowException
     */
    public function balance($address)
    {
        $url = $this->getApiUrl(__FUNCTION__);
        $response = http($url, [
            'address' => $address,
        ]);
        if ($response['code'] != 0) {
            throw new ThrowException($response['msg']);
        }
        $balance = $this->convertLower($response['data']['balance'] ?? 0,
            $this->currencyProtocol->decimal);
        return $balance;
    }

    /**
     * BTC转账
     *
     * @param        $from
     * @param        $private_key
     * @param        $to
     * @param        $number
     * @param        $type       /使用场景  1 归拢，2 打入手续费，3 提币
     * @param array  $extra_data /验证码
     *
     * @return mixed
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function transfer($from, $private_key, $to, $number, $type, $extra_data = [])
    {
        parent::transfer($from, $private_key, $to, $number, $type, $extra_data);
        $amount = self::convertUpper($number, $this->currencyProtocol->decimal);
        $fee = $this->getFeeNumber();
        $fee = self::convertUpper($fee, $this->currencyProtocol->decimal);

        $response = UDunClound::withdraw($this->currency->main_coin_type,
            $this->currency->coin_type,
            $amount,
            $to,
            env('CALLBACK_HOST') . '/' . 'api/notice/UDunNotice',
            $extra_data['businessId'],
            $extra_data['memo']
        );

        if ($response['code'] != 200) {
            throw new ThrowException($response['message']);
        }
        return $response['message'];
    }

    /**获取应该打入多少手续费
     *
     * @return int|void
     * @throws \Exception
     */
    public function getFeeNumber()
    {
        $fee = $this->currencyProtocol->chainProtocol->data['fee'] ?? 0;
        if (!$fee) {
            throw new \Exception('请去区块链协议设置此协议的手续费');
        }
        return $fee;
    }
}
