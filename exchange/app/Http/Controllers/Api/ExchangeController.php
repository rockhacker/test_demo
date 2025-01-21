<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ThrowException;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\ChangeAccount;
use App\Models\Account\ExchangeLog;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Subscription\Subscription;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class ExchangeController extends Controller
{

    public function submit()
    {

        try {
            DB::beginTransaction();

            $userId = User::getUserId();

            $base = request('base_id', '');
            $quote = request('quote_id', '');
            $amount = request('amount', '');//兑换数量

            $type = request('type', 1);//1买 2卖

            $check_new = Currency::where("is_new",1)->where("id",$base)->first();

            if($check_new){

                $sub = Subscription::where("currency_id",$base)
                        ->first();

                if($sub->status == 0){

                    return $this->error(__('api.该币种未上市，暂时无法兑换'));
                }else{

                    $lastPrice = $sub->market_price;
                }
            }else{

                $match_id = CurrencyMatch::where('quote_currency_id', $quote)
                    ->where('base_currency_id', $base)
                    ->value("id");

                if (empty($match_id)) {

                    return $this->error(__('api.交易对不存在'));
                }
                $match = CurrencyMatch::find($match_id);


                $lastPrice = $match->getLastPrice();
            }

            if($lastPrice <= 0){

                return $this->error(__('api.该币价值小于或等于零，暂时无法兑换'));
            }

            $base_account = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $base,
                $userId
            );

            $quote_account = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $quote,
                $userId
            );
            if($type == 1){
                $number = round($amount / $lastPrice ,8) ;

                $quote_account->transChangeBalance(AccountLog::EXCHANGE_DEP,-$amount) ;
                $base_account->transChangeBalance(AccountLog::EXCHANGE_INC,$number);
            }else{
                $number = round($lastPrice * $amount ,8) ;

                $base_account->transChangeBalance(AccountLog::EXCHANGE_DEP,-$amount);
                $quote_account->transChangeBalance(AccountLog::EXCHANGE_INC,$number);
            }

            ExchangeLog::insert([
                'user_id'=>$userId,
                'base_currency_id'=>$base,
                'quote_currency_id'=>$quote,
                'last_price'=>$lastPrice,
                'type'=>$type,
                'amount'=>$amount,
                'number'=>$number,
                'created_at'=>date("Y-m-d H:i:s")
            ]);

            DB::commit();

            return $this->success(__('api.兑换成功'));



        } catch (ThrowException | \Exception $e) {

            DB::rollBack();

            return $this->error($e->getMessage());
        }

    }


    public function lastPrice()
    {
        $base = request('base_id', 0);
        $quote = request('quote_id', 0);

        $check_new = Currency::where("is_new",1)->where("id",$base)->first();

        if($check_new){

            $price = Subscription::where("currency_id",$base)
                ->where("status",1)
                ->value("market_price") ?? 0;

            return $this->success(__("api.成功"),['last_price'=>$price]);
        }

        $match_id = CurrencyMatch::where('quote_currency_id', $quote)
            ->where('base_currency_id', $base)
            ->value("id");
        $match = CurrencyMatch::find($match_id);
        return $this->success(__("api.成功"),['last_price'=>$match->getLastPrice()]);
    }
}
