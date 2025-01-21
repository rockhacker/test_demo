<?php
/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2019/3/21
 * Time: 14:17
 */

namespace App\Http\Controllers\Admin;


use App\Models\Account\AccountType;
use App\Models\Forex\ForexSettleCurrency;
use App\Models\Forex\ForexTradeList;
use App\Models\Forex\ForexTransaction;
use App\Models\User\User;

class ForexTransactionController extends Controller
{

    public function index()
    {
        $closed_type_list = ForexTransaction::$closedTypeList;
        $status_list = ForexTransaction::$statusList;
        $forex = ForexTradeList::all();
        $settle_currencies = ForexSettleCurrency::all();
        return view('admin.forexTransaction.index',[
            'closed_type_list' => $closed_type_list,
            'status_list' => $status_list,
            'forex' => $forex,
            'settle_currencies' => $settle_currencies,
        ]);
    }

    public function list()
    {

        $forex_id = request()->input('forex_id', 0);
        $settle_currency_id = request()->input('settle_currency_id', 0);
        $order_type = request()->input('order_type', 0);
        $closed_type = request()->input('closed_type', -1);
        $mobile = request()->input('mobile', '');
        $account = request()->input('account', '');
        $email = request()->input('email', '');
        $limit = request()->input('limit', 10);
        $status = request()->input('status', -1);
        $start = request()->input("start_time", '');
        $end = request()->input("end_time", '');

        $results = ForexTransaction::with(['settleCurrency', 'TradeList', 'user'])
            ->when($settle_currency_id, function ($query) use ($settle_currency_id) {
                $query->where('settle_currency_id', $settle_currency_id);
            })->when($forex_id, function ($query) use ($forex_id) {
                $query->where('forex_id', $forex_id);
            })->when($order_type, function ($query) use ($order_type) {
                $query->where('order_type', $order_type);
            })->when($closed_type != -1, function ($query) use ($closed_type) {
                $query->where('closed_type', $closed_type);
            })->when($status != -1, function ($query) use ($status) {
                $query->where('status', $status);
            })->when($account != '', function ($query) use ($account) {
                $query->whereHas('user', function ($query) use ($account) {
                    // $account != '' && $query->where("mobile", $account)->orwhere('email', $account);
                    $query->where('uid', $account);
                });
            })->when($email, function ($query, $email) {
                $query->whereHas('user', function ($query) use ($email) {
                    $query->where('email', $email);
                });
            })->when($mobile, function ($query, $mobile) {
                $query->whereHas('user', function ($query) use ($mobile) {
                    $query->where('mobile', $mobile);
                });
            })->when($start != '', function ($query) use ($start) {
                $query->where('create_time', '>=', strtotime($start));
            })->when($end != '', function ($query) use ($end) {
                $query->where('create_time', '<=', strtotime($end));
            })->orderBy('id', 'desc')
            ->paginate($limit);
        $items = $results->getCollection();
        $items->each(function ($item, $key) {
            $item->create_time = date('Y-m-d H:i:s', $item->create_time);
            $item->transaction_time = date('Y-m-d H:i:s', $item->transaction_time);
            $item->update_time = date('Y-m-d H:i:s', $item->update_time);
            $item->handle_time = date('Y-m-d H:i:s', $item->handle_time);
            $item->complete_time = date('Y-m-d H:i:s', $item->complete_time);
        });
        $results->setCollection($items);
        return $this->layuiPageData($results);
    }

    public function close()
    {
        $id = request('id',0);
        $order = ForexTransaction::where(['id' => $id,'status' => ForexTransaction::STATUS_OPENED])->first();
        if(empty($order)){
            return $this->error('订单不存在或状态已变更');
        }
        $order->status = ForexTransaction::STATUS_CLOSING;
        $order->closed_type = ForexTransaction::CLOSED_TYPE_ADMIN;
        $order->save();
        return $this->success('平仓成功');
    }
}
