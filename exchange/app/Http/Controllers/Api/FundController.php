<?php

namespace App\Http\Controllers\Api;

use App\Events\Lever\LeverSubmitOrderEvent;
use App\Exceptions\ThrowException;
use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Currency\CurrencyMatch;
use App\Models\Fund\ApplyRefund;
use App\Models\Fund\Funds;
use App\Models\Fund\SubFund;
use App\Models\Fund\SubFundInterest;
use App\Models\Lever\LeverMultiple;
use App\Models\Lever\LeverTransaction;
use App\Models\Setting\Setting;
use App\Models\User\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class FundController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {

        $limit = request('limit', 10);
        $outs = Funds::with('currency')->where("is_show", 1)->orderBy('id', 'desc')->paginate($limit);

        return $this->success(__('api.请求成功'), $outs);
    }

    /**
     * @return JsonResponse
     */
    public function subList(): JsonResponse
    {

        $user_id = User::getUserId();

        $limit = request('limit', 10);
        $outs = SubFund::with("getFund")
            ->where("user_id",$user_id)
            ->orderBy('status')
            ->orderBy('id','desc')
            ->paginate($limit);

        return $this->success(__('api.请求成功'), $outs);
    }
    /**
     * @return JsonResponse
     */
    public function insList(): JsonResponse
    {

        $user_id = User::getUserId();

        $limit = request('limit', 10);
        $sub_id = request('sub_id', 0);
        $outs = SubFundInterest::with("getUserInfo")
            ->where("user_id",$user_id)
            ->where("sub_id",$sub_id)
            ->orderBy('id','desc')
            ->paginate($limit);

        return $this->success(__('api.请求成功'), $outs);
    }
    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function applyRefund(): JsonResponse
    {

        $user_id = User::getUserId();
        $subId = request('sub_id', 0);
        $subFund = SubFund::where("id",$subId)
            ->where("user_id",$user_id)
            ->where("status",1)
            ->where("is_return",0)
            ->first();
        if (!$subFund) {
            return $this->error(__('api.找不到该笔交易'));
        }
        if(ApplyRefund::where("user_id",$user_id)->where("sub_id",$subId)->where("status",1)->exists()){

            return $this->error(__('api.您已经申请过了'));
        }
        try {
            DB::beginTransaction();
            ApplyRefund::create([
                "user_id"=>$user_id,
                "sub_id"=>$subId,
                "fund_id"=>$subFund->fund_id,
                "status"=>1//申请中
            ]);
            SubFund::where("id",$subId)->update([
                "status"=>2//申请退款中
            ]);

            DB::commit();
            return $this->success(__('api.提交成功，等待审核'));

        }catch(Exception $exception){

            DB::rollBack();
            return $this->error($exception->getMessage());
        }

    }

    public function info(): JsonResponse
    {

        $id = request()->get("id", 0);
        $outs = Funds::with('currency')->where("is_show", 1)->where("id", $id)->first();

        return $this->success(__('api.请求成功'), $outs);

    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function buy(): JsonResponse
    {

        try {
            $fund_id = request()->get("id");
            $amount = request()->get("amount", 0);//购买金额
            DB::beginTransaction();
            $user_id = User::getUserId();

            $fund = Funds::where("id", $fund_id)->first();

            if (!$fund) {

                throw new ThrowException(__('model.未找到产品'), 404);
            }

            if ($fund->staring_sub_amount > $amount) {

                throw new ThrowException(__('model.起购份额不足'), 404);
            }
            if ($fund->max_sub_amount < $amount) {

                throw new ThrowException("Exceed the maximum order quantity", 404);
            }
            if ($amount <= 0) {

                throw new ThrowException("The subscription amount cannot be less than 0", 404);
            }
            if ($fund->status == Funds::LtSOver) {

                throw new ThrowException(__('model.产品已结束'), 404);
            }

            $legal = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $fund->currency_id,
                $user_id
            );
            $user_balance = $legal->balance;

            if ($amount > $user_balance) {

                throw new ThrowException(__('model.账户资金不足'), 404);
            }

            SubFund::create([
                "fund_id" => $fund->id,
                "user_id" => $user_id,
                "sub_time" => date("Y-m-d H:i:s"),
                "share_amount" => $amount,
                "is_return" => 0,
                'surplus_period'=>$fund->lock_dividend_days,
                "interest_gen_next_time"=>Funds::gen_next_time()
            ]);

            $legal->changeBalance(
                AccountLog::LOCK_SHARE,
                -$amount
            );
            $legal->changeLockBalance(AccountLog::LOCK_SHARE, $amount);
            DB::commit();
            return $this->success(__("api.成功"));
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage());
        }
    }
}
