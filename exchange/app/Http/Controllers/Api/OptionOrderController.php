<?php

namespace App\Http\Controllers\Api;

use App\Logic\MicroTrade;
use App\Logic\OptionTrade;
use App\Models\Account\OptionAccount;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Option\OptionNumber;
use App\Models\Option\OptionOrder;
use App\Models\Option\OptionPeriods;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionOrderController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function submit(Request $request): JsonResponse
    {
        try {
            $user_id = User::getUserId();
            $period_id = $request->input('period_id', 0);
            $match_id = $request->input('match_id', 0);
            $currency_id = $request->input('currency_id', 0);
            $number_id = $request->input('number_id', 0);
            $type = $request->input('type', 0);
            $validator = Validator::make($request->all(), [
                'match_id' => 'required|integer|min:1',
                'currency_id' => 'required|integer|min:1',
                'period_id' => 'required|integer|min:0',
                'number_id' => 'required|integer|min:0',
                'type' => 'required|integer',
            ], [], [
                'match_id' => '交易对',
                'currency_id' => '支付币种',
                'period_id' => '期数id',
                'number_id' => '下单id',
                'type' => '涨跌方向',
            ]);
            //进行基本验证
            throw_if($validator->fails(), new \Exception($validator->errors()->first()));


            $period = OptionPeriods::find($period_id);

            if(empty($period)){

                throw new \Exception(__('api.无法找到该期数'));
            }

            if($period->status != OptionPeriods::PeriodsNotRun){

                throw new \Exception(__('api.该期数已无法购买'));
            }

            $number = OptionNumber::find($number_id);

            if(empty($number)){

                throw new \Exception(__('api.无法找到该下单配置'));
            }

            $currency = Currency::find($currency_id);
            throw_unless($currency->option_account_display, new \Exception(__('api.当前币种账户不支持此交易')));
            $currencyMatch = CurrencyMatch::find($match_id);
            throw_unless($currencyMatch->open_option, new \Exception(__('api.当前交易对不支持此交易')));

            $order_data = [
                'user_id' => $user_id,
                'match_id' => $match_id,
                'period' => $period,
                'currency_id' => $currency_id,
                'number' => $number,
                'type'=>$type,
            ];
            $order = OptionTrade::addOrder($order_data);
            return $this->success(__('api.下单成功'), $order);

        }catch(\Throwable $th){
            return $this->error($th->getMessage());
        }

    }


    public function history(Request $request): JsonResponse
    {

        $user_id = User::getUserId();

        $limit = $request->input('limit', 10);
        $second_id = $request->input('second_id', 0);
        $status = $request->input('status', 1);

        $results = OptionOrder::with(['currencyMatch','period','currency','getUser'])
            ->where("user_id",$user_id)
            ->where("second_id",$second_id)
            ->where("status",$status)
            ->orderByDesc("id")
            ->paginate($limit);
        return $this->success(__('api.成功'), $results);
    }


    public function getSupportBalance(Request $request): JsonResponse
    {
        $user_id = User::getUserId();
        $currency_id = $request->input('currency_id', 0);
        $data = OptionAccount::where("currency_id",$currency_id)->where('user_id',$user_id)->first();

        return $this->success(__('api.成功'), $data);
    }
}
