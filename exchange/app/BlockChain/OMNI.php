<?php


namespace App\BlockChain;

use App\Logic\UDunClound;
use App\Models\Account\AccountLog;
use App\Models\Currency\Currency;
use App\Models\Chain\TxHash;
use App\Models\Account\Account;
use App\Utils\BC;
use App\Exceptions\ThrowException;
use GuzzleHttp\Exception\GuzzleException;

class OMNI extends BlockChain
{

    //公链类
    const MAIN_CHAIN_CLASS = BTC::class;

    const IS_TOKEN = true;

    protected $wallet;

    protected $currency_code = 31;

//    protected $address_attribute = 'omni_address';
    protected $address_attribute = 'address';
    protected $private_attribute = 'omni_private';

    public $recharge_method = self::API_METHOD;

    protected static function api()
    {
        $parent_api = parent::api();
        $api = [
            'balance' => '$HOST/wallet/btc/tokenbalance',
            'transfer' => '$HOST/v3/wallet/btc/tokensendto',
//            'bills' => 'http://39.98.228.203:3001/insight-api/addr/',
            'txStatus' => '$HOST/wallet/btc/tx',
        ];

        return array_merge($api, $parent_api);
    }


    public function balance($address)
    {
        $url = $this->getApiUrl(__FUNCTION__);
        $response = http($url, [
            'address' => $address,
            'propertyid'=> $this->currencyProtocol->token_address,
        ]);
        if ($response['code'] != 0) {
            throw new ThrowException($response['msg']);
        }
        $balance = $this->convertLower($response['data']['balance'] ?? 0,
            $this->currencyProtocol->decimal);
        return $balance;
    }

    /**
     * USDT转账
     *
     * @param        $from
     * @param        $private_key
     * @param        $to
     * @param        $number
     * @param        $type
     * @param array $extra_data
     *
     * @return mixed
     * @throws GuzzleException
     * @throws ThrowException
     */
    public function transfer($from, $private_key, $to, $number, $type, $extra_data=[])
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

    /**
     *
     */
    public function getFeeNumber()
    {
        $fee = $this->currencyProtocol->chainProtocol->data['fee'] ?? false;
        if (!$fee) {
            throw new \Exception('请去区块链协议设置此协议的手续费');
        }
        return $fee;
    }

    /**
     * 转手续费
     *
     * @param $from
     * @param $private_key
     * @param $to
     *
     * @return mixed
     * @throws ThrowException
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function transferFee($from, $private_key, $to, $number, $extra_data = [])
    {
        $btc = Currency::where('code', 'BTC')->first();
        if (!$btc) {
            throw new \Exception('OMNI转手续费需要依赖BTC币种');
        }
        $instance = self::newInstance($btc->currencyProtocols()->first());
        return $instance->transfer($from, $private_key, $to, $number, TxHash::FEE[0], $extra_data);
    }
}
