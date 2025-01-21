<?php


namespace App\Http\Controllers\Admin;


use App\Exceptions\ThrowException;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\Fund\ApplyRefund;
use App\Models\Fund\FundCommissionLists;
use App\Models\Fund\Funds;
use App\Models\Fund\FundsPeriods;
use App\Models\Fund\InterestFunds;
use App\Models\Fund\SetCommission;
use App\Models\Fund\SubFund;
use App\Models\Otc\Seller;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class FundController extends Controller
{


    public function list(request $request)
    {
        if ($request->method() == "POST") {

            $limit = $request->input('limit', 10);

            $title = $request->input('title', '');
            /** @var LengthAwarePaginator $funds */
            $funds = Funds::with('currency')->when($title != '', function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');

            })->orderBy('id', 'desc')->paginate($limit);

            return $this->layuiPageData($funds);

        } else {

            return view("admin.fund.list");
        }

    }

    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function add()
    {
        if (request()->method() == "POST") {
            try {

                $data = request()->all();

                $exists = Currency::where('id', $data['currency_id'])->exists();
                if (!$exists) {

                    throw new ThrowException('币种不存在');
                }

                if (empty($data['title'])) {

                    throw new ThrowException('标题必须填写');
                }
                if (empty($data['staring_sub_amount'])) {

                    throw new ThrowException('请输入起购金额');
                }
                if (empty($data['max_sub_amount'])) {

                    throw new ThrowException('请输入单笔最大金额');
                }
                if (empty($data['lock_dividend_days'])) {

                    throw new ThrowException('请输入锁仓天数');
                }
                if (empty($data['liquidated_damages'])) {

                    throw new ThrowException('请输入提前赎回违约金');
                }
                if (empty($data['dividend_percentage'])) {

                    throw new ThrowException('请输入每期派息百分比');
                }

//
//                if(empty($data['total_subscription_share'])){
//
//                    throw new ThrowException('总认购份额必须填写');
//                }
//                if(empty($data['staring_sub_share'])){
//
//                    throw new ThrowException('起购份数必须填写');
//                }
//
//                if(empty($data['each_subscription_amount'])){
//
//                    throw new ThrowException('每份认购金额必须填写');
//                }
//
//                if(empty($data['time'])){
//
//                    throw new ThrowException('时间必须选择');
//                }
//
//                if(empty($data['lock_dividend_days'])){
//
//                    throw new ThrowException('锁仓天数必须填写');
//                }
//
//                if(empty($data['lock_dividend_count'])){
//
//                    throw new ThrowException('锁仓派息次数必须填写');
//                }
//
//                if($data['lock_dividend_days'] < $data['lock_dividend_count']){
//
//                    throw new ThrowException('锁仓天数必须大于派息次数');
//                }
//
//                if(!is_int($data['lock_dividend_days'] / $data['lock_dividend_count'])){
//
//                    throw new ThrowException('锁仓天数除锁仓次数必须为整数');
//                }
//
//
//                if(empty($data['dividend_percentage'])){
//
//                    throw new ThrowException('派息百分比必须填写');
//                }

                $data['status'] = Funds::SUBSCRIPTING;//认购中
                unset($data['file']);
                Funds::create($data);

                return $this->success("添加成功");

            } catch (ThrowException $exception) {

                return $this->error($exception->getMessage());
            }

        } else {

            $currencies = Currency::get();
            return view("admin.fund.add", compact('currencies'));
        }
    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function edit()
    {
        $id = request()->input('id');

        if (request()->method() == "POST") {
            try {

                $data = request()->all();
                $exists = CurrencyProtocol::where('currency_id', $data['currency_id'])->exists();
                if (!$exists) {

                    throw new ThrowException('币种不存在');
                }

                if (empty($data['title'])) {

                    throw new ThrowException('标题必须填写');
                }
                if (empty($data['staring_sub_amount'])) {

                    throw new ThrowException('请输入起购金额');
                }
                if (empty($data['max_sub_amount'])) {

                    throw new ThrowException('请输入单笔最大金额');
                }
                if (empty($data['lock_dividend_days'])) {

                    throw new ThrowException('请输入锁仓天数');
                }
                if (empty($data['liquidated_damages'])) {

                    throw new ThrowException('请输入提前赎回违约金');
                }
                if (empty($data['dividend_percentage'])) {

                    throw new ThrowException('请输入每期派息百分比');
                }

                $data['status'] = Funds::SUBSCRIPTING;//认购中
                unset($data['file']);
                Funds::where("id", $id)->update($data);

                return $this->success("修改成功");
            } catch (ThrowException $exception) {

                return $this->error($exception->getMessage());
            }

        } else {

            $fund = Funds::find($id);

            $currencies = Currency::get();
            return view("admin.fund.edit", compact('currencies', "fund"));
        }
    }


    /**
     * @return Application|Factory|JsonResponse|View|int
     */
    public function periodsList()
    {
        $id = request()->input('id');

        $res = Funds::find($id);

        if (request()->isMethod("POST")) {

            $limit = request()->input('limit', 10);

            /** @var LengthAwarePaginator $funds */
            $list = FundsPeriods::where("fund_id", $id)->orderBy('id')->paginate($limit);

            return $this->layuiPageData($list);
        } else {

            if (empty($res)) {

                return 1;
            }

            return \view("admin.fund.periodsList", compact("res"));

        }

    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function periodsEdit()
    {

        $id = request()->input('id');

        $res = FundsPeriods::where("id", $id)->first();

        $each_dividend = request()->input('each_dividend');

        if (request()->isMethod("POST")) {

            if ($each_dividend <= 0) {

                return $this->error("派息百分比不能小于0");
            }
            try {
                DB::transaction(function () use ($res, $each_dividend) {

                    $res->update([
                        "each_dividend" => $each_dividend
                    ]);
                });
                return $this->success("修改成功");
            } catch (\Throwable $e) {

                return $this->error("修改失败，请重试");
            }

        } else {

            return \view("admin.fund.periodsEdit", compact("res"));
        }

    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function shareList()
    {
        $id = request()->input('id');
        $res = Funds::where("id", $id)->first();


        if (request()->isMethod("POST")) {

            $limit = request()->input('limit', 10);

            $list = SubFund::with("getUserInfo")->where("fund_id", $id)->orderBy('id')->paginate($limit);

            return $this->layuiPageData($list);

        } else {

            return \view("admin.fund.shareList", compact('res'));
        }


    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function cancelSub():JsonResponse
    {

        try {

            DB::beginTransaction();

            $id = request()->get("id", 0);

            $subFund = SubFund::where("id", $id)->lockForUpdate()->first();

            if ($subFund->status != 1) {

                throw new Exception("该认购状态订单无法被取消");
            }

            $subFund->update([
                'status' => 3,
                'is_return' => 1
            ]);

            $fund = Funds::find($subFund->fund_id);

            $legal = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $fund->currency_id,
                $subFund->user_id
            );
            $legal->changeBalance(
                AccountLog::LOCK_CANCEL_SHARE,
                $subFund->share_amount
            );
            $legal->changeLockBalance(AccountLog::SUB_PRINCIPAL_INTEREST, -($subFund->share_amount + $subFund->fund_amount));
            DB::commit();

            return $this->success("取消成功");

        } catch (Exception $exception) {

            DB::rollBack();

            return $this->error($exception->getMessage());
        }

    }

    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function grantInfo()
    {
        $id = request()->input('id');

        if (request()->isMethod("POST")) {

            $limit = request()->input('limit', 10);

            $list = InterestFunds::with("getUserInfo")->where("periods_id", $id)->orderBy('id', "desc")->paginate($limit);

            return $this->layuiPageData($list);

        } else {

            return \view("admin.fund.interestList", compact('id'));
        }


    }

    /**
     * @return Application|Factory|View
     */
    public function refund_audit()
    {
        return \view("admin.fund.refund_audit");
    }

    /**
     * @return JsonResponse
     */
    public function refund_audit_post(): JsonResponse
    {
        $limit = request()->input('limit', 10);
        $uid = request()->input('uid', '');
        $email = request()->input('email', '');

        $list = ApplyRefund::with("getUserInfo")->when($uid, function ($query, $uid) {
                $query->whereHas('getUserInfo',function ($query) use($uid){

                    $query->where("uid", $uid);
                });
            })
            ->when($email, function ($query, $email) {
                $query->whereHas('getUserInfo',function ($query) use($email){

                    $query->where("email", $email);
                });
            })
            ->with("getFund")
            ->with("getSubFund")
            ->orderBy('status')
            ->orderBy('id', "desc")
            ->paginate($limit);

        return $this->layuiPageData($list);

    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function post_apply(): JsonResponse
    {
        $type = request()->input('type', 0);
        $id = request()->input('id', 0);

        if ($type == 0) {

            return $this->error("状态设置失败");
        }

        $ar = ApplyRefund::find($id);

        if (!$ar) {

            return $this->error("无法找到该笔订单请求");
        }
        if ($ar->status != 1) {

            return $this->error("该笔请求已处理完成");
        }
        $fund = Funds::find($ar->fund_id);
        if (!$fund) {

            return $this->error("无法找到对应产品，或产品已被删除");
        }
        $order = SubFund::where("id", $ar->sub_id)->first();
        if (!$order) {

            return $this->error("无法找到对应产品，或产品已被删除");
        }
        try {
            DB::beginTransaction();

            if ($type == 2) {
                //驳回
                $ar->update([
                    "status" => $type
                ]);

                //如果申请后结束了订单需要进行过滤
                if ($order->status == 2) {

                    //把订单状态改成进行中
                    $order->update([
                        "status" => 1
                    ]);
                }

            } else {
                //退款
                $ar->update([
                    "status" => $type
                ]);
                if ($order->status != 2) {
                    throw new Exception("该笔申请关联的订单状态已更改，无法再进行退款");
                }
                //把订单状态改成已退款
                $order->update([
                    "status" => 3,
                    "is_return" => 1,
                ]);

                //计算违约金
//                $liquidatedDamages = round(($fund->liquidated_damages / 100) * $order->surplus_period, 4);

                //违约金金额
//                $liquidatedDamagesAmount = $order->share_amount * $liquidatedDamages;
                $liquidatedDamagesAmount = $order->share_amount * round(($fund->liquidated_damages / 100),4);
                //扣除违约金后的本金
                $amount = $order->share_amount - $liquidatedDamagesAmount;

                $legal = Account::getAccountByType(
                    AccountType::CHANGE_ACCOUNT_ID,
                    $fund->currency_id,
                    $order->user_id
                );
//                $legal->changeLockBalance(AccountLog::SUB_PRINCIPAL_INTEREST, -($amount + $order->fund_amount));
//                $legal->changeBalance(AccountLog::SUB_PRINCIPAL_INTEREST, ($amount + $order->fund_amount));
                $legal->changeLockBalance(AccountLog::SUB_LIQUIDATED_DAMAGES, -$liquidatedDamagesAmount);
                $legal->changeLockBalance(AccountLog::SUB_PRINCIPAL_INTEREST, -$amount);
                $legal->changeBalance(AccountLog::SUB_PRINCIPAL_INTEREST, $amount);

            }
            DB::commit();

            return $this->success("审核成功");

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());

        }

    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function setCommission()
    {
        $setting = SetCommission::where("id", 1)->first();

        if (request()->isMethod("POST")) {

            $class = request()->get("class", []);
            $status = request()->get("status", 0);

            if (!$class) {

                return $this->error("必须填写");
            }

            $levels = json_encode($class, 320);


            $data = [
                "levels" => $levels,
                "status" => $status
            ];

            if ($setting) {

                SetCommission::where("id", 1)->update($data);
            } else {
                $data['id'] = 1;
                SetCommission::create($data);
            }

            return $this->success("保存成功");
        } else {
            $levels = [];
            if (!$setting) {


            } else {

                $levels = json_decode($setting->levels, 320);
            }

            return \view("admin.fund.setCommission", compact('levels', 'setting'));
        }

    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function commissionList()
    {


        $id = request()->input('id');

        if (request()->isMethod("POST")) {

            $limit = request()->input('limit', 10);

            $list = FundCommissionLists::with("getUserInfo")->where("for_periods_id", $id)->orderBy('id', "desc")->paginate($limit);

            return $this->layuiPageData($list);

        } else {

            return \view("admin.fund.CommissionList", compact('id'));
        }
    }


    /**
     * @return Application|Factory|JsonResponse|View
     */
    public function sub_list()
    {

        if (request()->isMethod("POST")) {

            $limit = request()->input('limit', 10);
            $uid = request()->input('uid', '');
            $email = request()->input('email', '');

            $list = SubFund::with("getUserInfo")->when($uid, function ($query, $uid) {
                $query->whereHas('getUserInfo',function ($query) use($uid){

                    $query->where("uid", $uid);
                });
            })
                ->when($email, function ($query, $email) {
                    $query->whereHas('getUserInfo',function ($query) use($email){

                        $query->where("email", $email);
                    });
                })->with("getFund")->orderBy('id')
                ->paginate($limit);

            return $this->layuiPageData($list);

        } else {

            return \view("admin.fund.subList");
        }

    }
}
