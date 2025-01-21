<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Option\{OptionOrder, OptionPeriods, OptionSecond, OptionNumber};

class OptionController extends Controller
{
    public function index()
    {
        return view('admin.option.index');
    }

    public function secondsIndex()
    {
        return view('admin.option.seconds_index');
    }
    public function add(Request $request)
    {
        $id = $request->get('id', 0);
        if (empty($id)) {
            $result = new OptionNumber();
        } else {
            $result = OptionNumber::find($id);
        }
        $currencies = Currency::get()->filter(function ($currency) {

            /**@var $currency Currency* */
            return $currency->option_account_display;
        });

        return view('admin.option.add')->with('result', $result)->with('currencies', $currencies);
    }

    public function postAdd(Request $request)
    {
        $id = $request->get('id', 0);
        $currency_id = $request->get('currency_id', '');
        $number = $request->get('number', '');

        if (empty($id)) {
            $micro_number = new OptionNumber();
            if(OptionNumber::where('currency_id',$currency_id)->where('number',$number)->first()){
                return $this->error('已添加过');
            }
        } else {
            $micro_number = OptionNumber::find($id);
            if ($micro_number == null) {
                return redirect()->back();
            }
            if(OptionNumber::where('currency_id',$currency_id)->where('id','<>',$id)->where('number',$number)->first()){
                return $this->error('已添加过');
            }
        }
        $micro_number->currency_id = $currency_id;
        $micro_number->number = $number;

        DB::beginTransaction();
        try {
            $micro_number->save(); //保存币种
            DB::commit();
            return $this->success('操作成功');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }
    }

    public function lists(Request $request)
    {
        $limit = $request->get('limit', 10);
        $result = new OptionNumber();
        $result = $result->orderBy('id', 'desc')->paginate($limit);
        return $this->layuiPageData($result);
    }

    public function del(Request $request)
    {
        $id = $request->get('id', 0);
        $nicro_number = OptionNumber::find($id);
        if (empty($nicro_number)) {
            return $this->error('参数错误');
        }
        try {
            $nicro_number->delete();
            return $this->success('删除成功');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function secondsAdd(Request $request)
    {
        $id = $request->get('id', 0);
        if (empty($id)) {
            $result = new OptionSecond();
        } else {
            $result = OptionSecond::find($id);
        }
        return view('admin.option.seconds_add')
            ->with('result', $result);
    }

    public function secondsPostAdd(Request $request)
    {
        $id = $request->get('id', 0);
        $seconds = $request->get('seconds', '');
        $status = $request->get('status', '');
        $profit_ratio = $request->get('profit_ratio', '');

        if ($seconds < 10) {
            return $this->error('秒数最小不能小于10秒');
        }

        if (empty($id)) {
            if(OptionSecond::where('seconds',$seconds)->first()){
                return $this->error('已添加过');
            }
            $result = new OptionSecond();
        } else {
            if(OptionSecond::where('seconds',$seconds)->where('id','<>',$id)->first()){
                return $this->error('已添加过');
            }
            $result = OptionSecond::find($id);
            if ($result == null) {
                return redirect()->back();
            }
        }
        $result->seconds = $seconds;
        $result->profit_ratio = $profit_ratio;
        $result->status = $status;

        DB::beginTransaction();
        try {
            $result->save(); //保存币种
            DB::commit();
            return $this->success('操作成功');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }
    }

    public function secondsLists(Request $request)
    {
        $limit = $request->get('limit', 10);
        $result = new OptionSecond();
        $result = $result->orderBy('id', 'desc')->paginate($limit);
        return $this->layuiPageData($result);
    }

    public function secondsDel(Request $request)
    {
        $id = $request->get('id', 0);
        $result = OptionSecond::find($id);
        if (empty($result)) {
            return $this->error('参数错误');
        }
        try {
            $result->delete();
            return $this->success('删除成功');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function secondsStatus(Request $request)
    {
        $id = $request->get('id', 0);
        $result = OptionSecond::find($id);
        if (empty($result)) {
            return $this->error('参数错误');
        }
        if ($result->status == OptionSecond::STATUS_ON) {
            $result->status = OptionSecond::STATUS_OFF;
        } else {
            $result->status = OptionSecond::STATUS_ON;
        }
        try {
            $result->save();
            return $this->success('操作成功');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function option_periods_index(Request $request)
    {
        if ($request->isMethod("POST")){

            $status = $request->input("status", -1);
            $profit_result = $request->input('profit_result', -1);
            $match_id = $request->input('match_id', -1);
            $limit = $request->input('limit', 10);

            $results = OptionPeriods::with(['currencyMatch',"second"])
                ->when($status != -1 ,function($query) use ($status){

                    $query->where("status",$status);
                })
                ->when($profit_result != -1 , function($query) use($profit_result) {

                    $query->where("result",$profit_result);
                })
                ->when($match_id != -1 , function($query) use($match_id) {

                    $query->where("currency_match_id",$match_id);
                })
                ->orderBy("id","desc")
                ->paginate($limit);

            return $this->layuiPageData($results);

        }else{

            $currencies = Currency::get()->filter(function ($item, $key) {
                return $item->option_account_display;
            })->values();
            $currency_matches = CurrencyMatch::where('open_option', CurrencyMatch::ON)->get();
            return view('admin.option.option_periods_index')
                ->with('currencies', $currencies)
                ->with('currency_matches', $currency_matches);
        }

    }


    public function orders(Request $request)
    {

        if ($request->isMethod("POST")){

            $status = $request->input("status", -1);
            $profit_result = $request->input('profit_result', -1);
            $match_id = $request->input('match_id', -1);
            $email = $request->input('email', "");
            $limit = $request->input('limit', 10);

            $results = OptionOrder::with(['currencyMatch','period','currency','getUser'])
                ->when($status != -1 ,function($query) use ($status){

                    $query->where("status",$status);
                })
                ->when($profit_result != -1 , function($query) use($profit_result) {

                    $query->where("result",$profit_result);
                })
                ->when($match_id != -1 , function($query) use($match_id) {

                    $query->where("match_id",$match_id);
                })
                ->when($email, function ($query, $email) {
                    $query->whereHas('getUser', function ($query) use ($email) {
                        $query->where('email', $email);

                    });
                })
                ->orderByDesc("id")
                ->paginate($limit);

            return $this->layuiPageData($results);

        }else{

            $currencies = Currency::get()->filter(function ($item, $key) {
                return $item->option_account_display;
            })->values();
            $currency_matches = CurrencyMatch::where('open_option', CurrencyMatch::ON)->get();
            return view('admin.option.orders')
                ->with('currencies', $currencies)
                ->with('currency_matches', $currency_matches);
        }

    }

}
