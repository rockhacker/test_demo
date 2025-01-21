<?php
/**
 * Created by PhpStorm.
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account\AccountLog;
use App\Models\Account\ChangeAccount;
use App\Models\Currency\Currency;
use App\Models\Project\Project;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionOrders;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function coin_manager_list()
    {

        return view("admin.subscription.coin_manager_list");
    }

    /**
     * @return JsonResponse
     */
    public function coin_manager_list_post(): JsonResponse
    {
        $limit = request('limit', 10);
        $list = Subscription::with(['currency'])->paginate($limit);

        return $this->layuiPageData($list);
    }


    public function edit_sub()
    {
        $id = request('id', 0);
        $data = Subscription::find($id);
        return view("admin.subscription.edit_sub", ['data' => $data]);
    }

    /**
     * @return JsonResponse
     */
    public function save_edit_sub(): JsonResponse
    {
        $id = request("id", 0);
        $sub = Subscription::find($id);

        if (empty($sub)) {

            return $this->error("申购已不存在");
        }

        $range_time = request("range_time", "");
        $market_time = request("market_time", "");
        $sub->sub_price = request("sub_price", 0);
        $sub->market_price = request("market_price", 0);
        $sub->is_show = request("is_show", 0);

        if (empty($range_time)) {

            return $this->error("申购开始结束时间必须选择");
        }
        $range_time = explode(" - ", $range_time);

        $sub->start_time = $range_time[0];
        $sub->finish_time = $range_time[1];

        if ($market_time < $sub->finish_time) {

            return $this->error("上市时间必须大于申购结束时间");
        }
        $sub->market_time = $market_time;

        if ($sub->sub_price <= 0 || $sub->market_price <= 0) {

            return $this->error("价格设置必须大于0");
        }
        $sub->save();

        return $this->success("修改成功");
    }

    /**
     * @return Application|Factory|View
     */
    public function add_sub()
    {
        $currencies = Currency::where("is_new", 1)->get();

        return view("admin.subscription.add_sub", ['currencies' => $currencies]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save_sub(Request $request): JsonResponse
    {
        $input = $request->input();

        if (Subscription::where("currency_id", $input['currency_id'])->exists()) {

            return $this->error("该币种已添加过");
        }

        if (empty($input['range_time'])) {

            return $this->error("申购开始结束时间必须选择");
        }
        $range_time = explode(" - ", $input['range_time']);
        $input['start_time'] = $range_time[0];
        $input['finish_time'] = $range_time[1];

        if ($input['market_time'] < $input['finish_time']) {

            return $this->error("上市时间必须大于申购结束时间");
        }

        if ($input['sub_price'] <= 0 || $input['market_price'] <= 0) {

            return $this->error("价格设置必须大于0");
        }

        if ($input['issue_number'] <= 0) {

            return $this->error("最大发行数必须大于0");
        }
        unset($input['range_time']);

        Subscription::create($input);

        return $this->success("添加成功");
    }

    /**
     * @return Application|Factory|View
     */
    public function purchase_record()
    {
        $id = request("id", 0);
        return \view("admin.subscription.purchase_record", ['id' => $id]);
    }

    /**
     * @return JsonResponse
     */
    public function get_purchase_record(): JsonResponse
    {
        $id = request("id", 0);
        $limit = request('limit', 10);

        $list = SubscriptionOrders::with("getUserInfo")
            ->with("payCurrency")
            ->with("subscription")
            ->where("sub_id",$id)
            ->orderByDesc("id")
            ->paginate($limit);
        return $this->layuiPageData($list);
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function sub_ref(): JsonResponse
    {
        $id = request("id", 0);

        $order = SubscriptionOrders::find($id);

        if(empty($order)){

            return $this->error("无法找到订单");
        }

        if($order->is_return != 0){

            return $this->error("订单已被处理过，无法全额退款");
        }

        if($order->status > 2){

            return $this->error("该状态下无法全额退款");
        }

        try {
            \DB::beginTransaction();
            $account = ChangeAccount::getAccountForLock($order->pay_currency_id,$order->user_id);
            $account->changeBalance(AccountLog::SUBSCRIPTION_REF, $order->pay_amount);

            $order->is_return = 3;
            $order->status = 5;
            $order->save();

            \DB::commit();
            return $this->success("退款成功");

        } catch (Exception $e) {
            \DB::rollBack();
            return $this->error($e->getMessage());
        }

    }


    /**
     * @return Application|Factory|View
     */
    public function lottery_management()
    {
        $id = request("id", 0);

        $order = SubscriptionOrders::find($id);
        return \view("admin.subscription.lottery_management", ['order' => $order]);
    }

    /**
     * @return JsonResponse
     */
    public function lottery_update(): JsonResponse
    {

        $is_win = request("is_win",0);
        $id = request("id",0);
        $winning_lots_number = request('winning_lots_number',0);


        $order = SubscriptionOrders::find($id);
        if($order->is_return != 0){

            return $this->error("该订单已产生退款,无法再申请中签");
        }
        if($order->status > 3){

            return $this->error("该订单的状态已无法再修改中签状态");
        }

        if($is_win == 1){
            //已中签
            if($winning_lots_number <= 0){

                return $this->error("已中签必须填写中签数量");
            }
            $order->status = 3;
            $order->winning_lots_number = $winning_lots_number;
        }elseif($is_win == 2){
            //待抽签
            $order->status = 1;

        }elseif($is_win == 0){

            $order->status = 2;
            $order->winning_lots_number = 0;
        }
        $order->save();

        return $this->success("修改成功");
    }
}
