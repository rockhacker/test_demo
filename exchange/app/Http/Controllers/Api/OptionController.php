<?php

namespace App\Http\Controllers\Api;

use App\Logic\MicroTrade;
use App\Logic\OptionTrade;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Option\OptionNumber;
use App\Models\Option\OptionOrder;
use App\Models\Option\OptionPeriods;
use App\Models\Option\OptionSecond;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getOptionMatches(): JsonResponse
    {
        $currencyMatches = CurrencyMatch::with('currencyQuotation')->where("open_option",1)->get();
        return $this->success(__('api.请求成功'), $currencyMatches);
    }




    public function getOrderTime(): JsonResponse
    {

        $data = OptionSecond::where("status",1)->get();

        return $this->success(__('api.请求成功'), $data);
    }


    public function getPeriods(): JsonResponse
    {

        $match_id = request()->input('match_id',0);
        $sec_id = request()->input('sec_id',0);
        $limit = request()->input('limit',10);

        $data = OptionPeriods::where('currency_match_id',$match_id)
            ->where('result',"!=",0)
            ->where("seconds_id",$sec_id)
            ->orderByDesc("id")
            ->limit($limit)
            ->get();


        return $this->success(__('api.请求成功'), $data);
    }

    public function getChoosePeriods(): JsonResponse
    {

        $match_id = request()->input('match_id',0);
        $sec_id = request()->input('sec_id',0);
        $status = request()->input('status',0);

        $data = OptionPeriods::where('currency_match_id',$match_id)
            ->where('status',$status)
            ->where("seconds_id",$sec_id)
            ->first();


        return $this->success(__('api.请求成功'), $data);
    }


    public function getAmount()
    {

        $data = OptionNumber::with(['currency'])->get();

        return $this->success(__('api.请求成功'), $data);

    }























}
