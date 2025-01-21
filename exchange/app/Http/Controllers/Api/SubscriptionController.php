<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ThrowException;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\ChangeAccount;
use App\Models\Account\ChangeAccountLog;
use App\Models\Account\LegalAccount;
use App\Models\Account\LeverAccount;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Fund\SubFund;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionOrders;
use App\Models\User\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function subscription_list(): JsonResponse
    {

        $limit = request('limit', 10);
        $outs = Subscription::with(["currency"])
            ->where("is_show",1)
            ->orderBy('id','desc')
            ->paginate($limit);
        foreach ($outs as $k=>$v){
            $outs[$k]['currency_match_id'] = CurrencyMatch::where('base_currency_id',$v['currency_id'])->value('id');
        }
        return $this->success(__('api.请求成功'), $outs);
    }

    /**
     * 取允许支付的币种
     *
     * @return JsonResponse
     */
    public function getPayableCurrencies(): JsonResponse
    {
        $currencies = Currency::where("is_new",0)->get()->filter(function ($currency, $key) {
            return $currency->change_account_display;
        })->values();

        $currencies = $currencies->transform(function ($currency, $key) {
            // 追加上用户的钱包
            try {
                $account = Account::getAccountByType(AccountType::CHANGE_ACCOUNT_ID, $currency->id);
                $currency->setAttribute('change_account', $account ?? null);
                return $currency;
            } catch (ThrowException $e) {

            }
        })->filter(function ($currency) {
            return !is_null($currency);
        })->values();
        return $this->success('', $currencies);
    }

    public function submit(): JsonResponse
    {

        $user_id = User::getUserId();
//        //申购金额
//        $number = request("number",0);
        //申购金额
        $amount = request("amount",0);
        //新币申购id
        $sub_id = request("sub_id",0);

        //支付的币种id
        $pay_currency_id = request("pay_currency_id",0);

        if(!$pay_currency_id){

            return $this->error(__("api.支付币种必须选择"));
        }

        $sub = Subscription::lockForUpdate()->find($sub_id);
        if(empty($sub)){

            return $this->error(__("api.找不到这个单子"));
        }

        if($amount <= 0){

            return $this->error(__("api.申购金额不能少于或等于零"));
        }


        $time = date("Y-m-d H:i:s");

        if($sub->start_time > $time){

            return $this->error(__("api.申购未开始"));
        }
        if($sub->finish_time < $time){

            return $this->error(__("api.申购已结束"));
        }

        try{
            DB::beginTransaction();

            $account = ChangeAccount::getAccountForLock($pay_currency_id,$user_id);
            if(empty($account)){

                throw new Exception(__("api.找不到账户"));
            }

            $u_curr_id = Currency::where("code","USDT")->value("id");

            if($u_curr_id == $pay_currency_id ){

                $last_price = 1;

            }else{
                $currency_match_id = CurrencyMatch::where("quote_currency_id",$u_curr_id)
                    ->where('base_currency_id',$pay_currency_id)->value("id");

                $match = CurrencyMatch::findOrFail($currency_match_id);
                $last_price = $match->getLastPrice();
                if (empty($last_price)) {
                    throw new Exception(__('api.当前没有获取到行情价格,请稍后重试'));
                }
            }

            //转换为U的数量
            $b_ = $last_price * $amount;
            //计算申购数量
            $number = round($b_/$sub->sub_price,4);

            if($number+$sub->subscribed > $sub->issue_number){

                return $this->error(__("api.剩余申购数量不足"));
            }

            $order = new SubscriptionOrders();
            $order->user_id = $user_id;
            $order->sub_id = $sub_id;
            $order->number = $number;
            $order->pay_currency_id = $pay_currency_id;
            $order->pay_amount = $amount;
            $order->pay_last_price = $last_price;
            $order->save();
            //扣除金额
            $account->transChangeBalance(AccountLog::SUBSCRIPTION_DEP,-$amount);

            $sub->subscribed = $sub->subscribed + $number;
            $sub->save();
            DB::commit();

            return $this->success(__("api.申购成功"));
        }catch(Exception $ex){

            DB::rollBack();
            return $this->error($ex->getMessage());
        }
    }

    public function sub_info(): JsonResponse
    {

        $id = request('id', 0);
        $outs = Subscription::where("id",$id)->with(["currency"])
            ->first();

        return $this->success(__('api.请求成功'), $outs);
    }

    public function mySubList(): JsonResponse
    {
        $limit = request("limit",10);
        $user_id = User::getUserId();
        $orders = SubscriptionOrders::with(['payCurrency','subscription'])
            ->where("user_id",$user_id)
            ->paginate($limit);

        return $this->success(__('api.请求成功'), $orders);
    }


    public function SubAccountLog()
    {

        $currency_id = request('currency_id');
        $limit = request('limit', 15);
        $logs = ChangeAccountLog::with(['currency'])->when($currency_id, function ($query) use ($currency_id) {
            $query->where('currency_id', $currency_id);
        })->where('user_id', User::getUserId())
            ->where('is_lock', AccountLog::NO_LOCK)
            ->whereIn('type', [
                AccountLog::SUBSCRIPTION_DEP[0],
                AccountLog::SUBSCRIPTION_REF[0],
                AccountLog::ISSUED_COINS[0],
            ])
            ->orderBy('id', 'desc')
            ->paginate($limit);
        return $this->success(__('api.请求成功'), $logs);
    }
}
