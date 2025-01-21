<?php


namespace App\BlockChain;

use App\Logic\UDunClound;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Chain\ChainWallet;
use App\Models\Chain\TxHash;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ThrowException;

class LTC extends BlockChain
{
    //是否需要打入手续费
    const TRANSFER_FEE = false;

    //是否需要归拢
    const COLLECT = false;


    protected $currency_code = 2;

    public $recharge_method = self::BILL_METHOD;

    protected static function api()
    {
        $parent_api = parent::api();
        $api = [
            'transfer' => '$HOST/v3/wallet/xrp/sendto',
            'bills' => 'https://data.ripple.com/v2/accounts/$ACCOUNT/payments',
        ];

        return array_merge($api, $parent_api);
    }

    public function txStatus($tx_hash)
    {
        $status = TxHash::STATUS_SUCCESS;
        return $status;
    }

//    public function generateOnlineWallet($user, $addresses = [])
//    {
//        $this->generateMemoOnlineWallet($user);
//    }

    /**
     * LTC转账
     *
     * @param        $from
     * @param        $private_key
     * @param        $to
     * @param        $number
     * @param        $type
     * @param array  $extra_data
     *
     * @return mixed|void
     * @throws ThrowException
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

    /**账单充值
     *
     * @param BlockChain $blockChain
     * @throws GuzzleException
     * @throws ThrowException
     */
    public function billRecharge($blockChain)
    {
        $bills = $this->bills($blockChain->currencyProtocol->in_address);
        foreach ($bills as $bill) {
            try {
                DB::transaction(function () use ($bill) {

                    $amount = $bill['amount'] ?? 0;
                    if ($amount <= 0) {
                        Log::channel('wallet_recharge')->error("充值金额错误,跳过", $bill);
                        return false;
                    }
                    $memo = $bill['destination_tag'] ?? '';
                    if (!$memo) {
                        Log::channel('wallet_recharge')->error("没有memo,跳过", $bill);
                        return false;
                    }
                    $chainWallet = ChainWallet::where('memo', $memo)->first();
                    if (!$chainWallet) {
                        Log::channel('wallet_recharge')->error("找不到钱包,跳过", $bill);
                        return false;
                    }
                    $account_type_id = AccountType::where('is_recharge', AccountType::IS_RECHARGE)->first();
                    if (!$account_type_id) {
                        Log::channel('wallet_recharge')->error("找不到账户", $bill);
                        return false;
                    }
                    $hash = $bill['tx_hash'];
                    //如果已经处理过则不处理
                    if (TxHash::where('hash', $hash)->exists()) {
                        return true;
                    }
                    $account = Account::getAccountByType($account_type_id->id, $chainWallet->currency_id,
                        $chainWallet->user_id);
                    $account->changeBalance(AccountLog::BLOCK_CHAIN_ADD, $amount);
                    TxHash::insertHash($chainWallet->user_id, $this->currency->id, TxHash::RECHARGE, $hash,
                        $this->currencyProtocol->id);
                    Log::channel('wallet_recharge')->error("充值成功XRP,UID:{$account->user()->value('uid')}", $bill);
                });
            } catch (\Throwable $t) {
                Log::channel('wallet_recharge')->error("充值发生错误", [$t->getMessage()]);
                dump($t->getMessage());
            }

        }
    }

    /**
     * 获取账户充值记录
     *
     * @param $address
     *
     * @return array|mixed
     * @throws GuzzleException|ThrowException
     */
    public function bills($address)
    {
        $url = self::getApiUrl(__FUNCTION__);
        $url = str_replace('$ACCOUNT', $address, $url);
        $response = http($url, [
            'type' => 'received',
            'currency' => 'LTC',
            'limit' => 100,
            'start' => str_replace(' ', 'T', now()->subMinutes(10)->toDateTimeString() . 'Z'),
            'end' => str_replace(' ', 'T', now()->toDateTimeString() . 'Z'),
        ]);
        return $response['payments'] ?? [];
    }
}
