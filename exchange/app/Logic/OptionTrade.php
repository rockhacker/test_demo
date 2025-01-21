<?php

namespace App\Logic;

use App\Models\Option\OptionOrder;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\User\User;
use App\Models\Account\{AccountLog, OptionAccount};
use App\Models\Currency\{Currency, CurrencyMatch};
use Throwable;

class OptionTrade
{
    /**
     * 添加一个交易订单
     *
     * @param array $param
     *
     * @return OptionOrder
     * @throws Exception
     * @throws Throwable
     */
    public static function addOrder(array $param): OptionOrder
    {
        list (
            'user_id' => $user_id,
            'match_id' => $match_id,
            'period' => $period,
            'currency_id' => $currency_id,
            'number' => $number,
            'type' => $type,
            ) = $param;
        try {
            DB::beginTransaction();
            //检测用户是否存在
            $user = User::find($user_id);
            throw_unless($user, new Exception('用户无效'));
            //检测交易对是否存在
            $currency_match = CurrencyMatch::findOrFail($match_id);
            throw_unless($currency_match, new Exception('交易对不存在'));
            throw_unless($currency_match->open_option, new Exception('交易未开启'));
            $currency = Currency::findOrFail($currency_id);
            throw_unless($currency->option_account_display, new Exception('币种不允许被交易'));

            //扣款
            $account = OptionAccount::getAccountForLock($currency_id, $user_id);
            throw_unless($account, new Exception("用户{$currency->code}币种对应账户不存在"));
            $account->OptionChangeBalance(AccountLog::OPTION_TRADE_ORDER, -$number->number);
            $fee = bc($currency->option_trade_fee, '*', $number->number);
            $account->OptionChangeBalance(AccountLog::OPTION_TRADE_ORDER_FEE, -$fee,["fee"=>$fee]);

            //生成交易数据
            $order_data = [
                'user_id' => $user_id,
                'match_id' => $currency_match->id,
                'currency_id' => $currency->id,
                'second_id' => $period->seconds_id,
                'period_id' => $period->id,
                'number' => $number->number,
                'number_id' => $number->id,
                'fee' => $fee,
                'type' => $type,
                'status' => OptionOrder::STATUS_OPENED,
            ];

            //添加一个交易
            $result = OptionOrder::unguarded(function () use ($order_data) {

                return OptionOrder::create($order_data);
            });

            DB::commit();
            return $result;
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


}
