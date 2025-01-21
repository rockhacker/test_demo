<?php


namespace App\BlockChain;


use App\Exceptions\ThrowException;
use App\Logic\UDunClound;

class ETC extends BlockChain
{


    protected $currency_code = 61;

//    protected $address_attribute = 'etc_address';
    protected $private_attribute = 'etc_private';
    public $recharge_method = self::API_METHOD;


    protected static function api()
    {
        $parent_api = parent::api();
        $api = [
            'balance' => '$HOST/wallet/etc/balance',
            'transfer' => '$HOST/v3/wallet/etc/sendto',
            'txStatus' => '$HOST/wallet/etc/tx',
        ];

        return array_merge($api, $parent_api);
    }

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
     * 转账
     *
     * @param        $from
     * @param        $private_key
     * @param        $to
     * @param        $number
     * @param        $type
     * @param string $code
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function transfer($from, $private_key, $to, $number, $type, $extra_data = [])
    {

//        $gas_price = $this->currencyProtocol->chainProtocol->data['gas_price'] ?? false;
//        $gas_limit = $this->currencyProtocol->chainProtocol->data['gas_limit'] ?? false;
//        if (!$gas_price || !$gas_limit) {
//            throw new ThrowException('请去区块链协议设置此协议的手续费');
//        }
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


    /**
     *
     */
    public function getFeeNumber()
    {
        $gas_price = $this->currencyProtocol->chainProtocol->data['gas_price'] ?? false;
        $gas_limit = $this->currencyProtocol->chainProtocol->data['gas_limit'] ?? false;
        if (!$gas_price || !$gas_limit) {
            throw new \Exception('请去区块链协议设置此协议的手续费');
        }
        $number = $gas_price * $gas_limit;

        $fee = self::convertLower($number, 18);
        return $fee;
    }
}
