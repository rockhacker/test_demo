<?php


namespace App\Http\Controllers\Api;

use App\Exceptions\ThrowException;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\ChangeAccount;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Tx\TxNew;
use App\Models\User\User;

class NewTxController extends Controller
{

    //购买币种
    public function currencies(): \Illuminate\Http\JsonResponse
    {
        $currencies = Currency::all();
        $change_account = AccountType::where('account_code', 'change_account')
            ->firstOrFail();
        $currencies = $currencies->filter(function ($item) use ($change_account) {
            return in_array($change_account->id, $item->accounts_display);
        })->values();
        return $this->success(__('api.请求成功'), $currencies);
    }

    /**发布买
     *
     * @throws ThrowException
     */
    public function in(): \Illuminate\Http\JsonResponse
    {
        return transaction(function () {
            $user_id = User::getUserId();
            $invite_code = request('invite_code', '');
            $pb_currency_id = request('pb_currency_id', 0);//平台币
            $base_currency_id = request('base_currency_id', 0);
            $number = request('number', 0);

            $number = bc($number, '+', 0, 4);

            if (!is_numeric($number) || $number <= 0) {
                return $this->error(__('api.数量错误'));
            }
            if ($pb_currency_id == $base_currency_id) {
                return $this->error(__('api.不支持选择平台代币'));
            }
            $pb_currency = Currency::find($pb_currency_id);
            $base_currency = Currency::find($base_currency_id);
            if(!$pb_currency || !$base_currency){
                return $this->error(__('api.参数错误'));
            }
            if ($pb_currency->is_pb != 1) {
                return $this->error(__('api.购买的不是平台代币，暂不支持'));
            }
            if(!User::where('invite_code',$invite_code)->first()){
                return $this->error(__('api.邀请码不正确'));
            }

            $usdt = Currency::where('code', 'USDT')->firstOrFail();

            if ($base_currency_id == $usdt->id) {
                $pb_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $pb_currency_id)->first();
                if ($pb_match) {
                    $pb_quo = CurrencyQuotation::where('currency_match_id', $pb_match->id)->first();
                    $pb_price = $pb_quo->close ?? 0;

                } else {
                    $pb_price = $pb_currency->usd_price;
                }

                $base_price =1;

            } else {
                $pb_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $pb_currency_id)->first();
                $base_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $base_currency_id)->first();
                if (!$pb_match || !$base_match) {
                    $pb_price = $pb_currency->usd_price;
                    $base_price = $base_currency->usd_price;
                } else {
                    $pb_quo = CurrencyQuotation::where('currency_match_id', $pb_match->id)->first();
                    $base_quo = CurrencyQuotation::where('currency_match_id', $base_match->id)->first();
                    $pb_price = $pb_quo->close ?? 0;
                    $base_price = $base_quo->close ?? 0;
                }
                if ($pb_price == 0 || $base_price == 0) {
                    return $this->error(__('api.币种价格有误'));
                }


            }
            //$price = bc($base_price, '/', $pb_price); //相对价格 ??

            $price = bc($pb_price, '/', $base_price); //相对价格 ??

            $baseWallet = ChangeAccount::where('user_id', $user_id)
                ->where('currency_id', $base_currency_id)->lockForUpdate()->first();


            $pbWallet = ChangeAccount::where('user_id', $user_id)
                ->where('currency_id', $pb_currency_id)->lockForUpdate()->first();

            //买
            //$amount = bc($number, '*', $price, 4);
            $amount = bc($number, '/', $price, 4);

            $baseWallet->changeBalance(AccountLog::TX_IN_MATCH_SUB, -$number);
            $fee    = 0;
            $pbWallet->changeBalance(AccountLog::TX_IN_MATCH_ADD, $amount);

            $order = TxNew::create([
                'type' => 1,
                'number'            => $amount,
                'price'             => $price,
                'currency_match_id' => 0,
                'user_id'           => $user_id,
                'quote_currency_id' => $base_currency_id,
                'base_currency_id' => $pb_currency_id,
                'amount' => $number,
                'fee' => $fee,
                'quote_price' => $base_price,
                'base_price' => $pb_price,
                'invite_code'=>$invite_code

            ]);

            return $this->success(__('api.买币成功'), $order);
        });
    }


    /**列表
     *
     */
    public function list()
    {
        $limit = request('limit', 10);
        $currency_match_id = request('currency_match_id', 0);
        $type = request('type', 0);
        $ins = TxNew::with('currencyMatch')->where('user_id', User::getUserId())
            ->when($currency_match_id, function ($query, $currency_match_id) {
                $query->where('currency_match_id', $currency_match_id);
            })->when($type, function ($query, $type) {
                $type > 0 && $query->where('type', $type);
            })->orderBy('id', 'DESC')->paginate($limit);
        return $this->success(__('api.请求成功'), $ins);
    }
}
