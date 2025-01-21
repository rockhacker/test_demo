<?php

namespace App\Http\Controllers\Admin;

use App\Events\Lever\LeverClosedEvent;
use App\Events\Lever\UStandardClosedEvent;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\LeverAccount;
use App\Models\Currency\CurrencyMatch;
use App\Models\Lever\LeverTransaction;
use App\Models\Lever\LeverUStandard;
use App\Models\Lever\LeverUStandardHistory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UStandardController extends Controller
{

    public function Leverdeals_show()
    {
        $matches = CurrencyMatch::where('open_lever', 1)->get();
        return view("admin.uStandard.list", [
            'matches' => $matches,
        ]);
    }
    public function Leverdeals_position()
    {
        $matches = CurrencyMatch::where('open_lever', 1)->get();
        return view("admin.uStandard.position", [
            'matches' => $matches,
        ]);
    }

    //合约交易
    public function Leverdeals(Request $request)
    {
        $limit = $request->input("limit", 10);
        $match_id = $request->input('match_id', 0);
        $uid = $request->input("uid", '');
        $mobile = $request->input("mobile", '');
        $email = $request->input("email", '');
        $status = $request->input("status", -1);
        $type = $request->input("type", 0);
        $start_time = $request->input("start_time", '');
        $end_time = $request->input("end_time", '');
        $is_position = $request->input('is_position',0);
        $quote_currency_id = 0;
        $base_currency_id = 0;
        if ($match_id > 0) {
            $match = CurrencyMatch::find($match_id);
            $quote_currency_id = $match->quote_currency_id ?? 0;
            $base_currency_id = $match->base_currency_id ?? 0;
        }

        if(in_array($status,[LeverUStandard::STATUS_ENTRUST,LeverUStandard::STATUS_TRANSACTION,LeverUStandard::STATUS_CLOSING])){
            $class = LeverUStandard::class;
        } else {
            $class = LeverUStandardHistory::class;
        }
        if($is_position){
            $class = LeverUStandard::class;
        }
        $order_list = $class::when($quote_currency_id > 0, function ($query) use ($quote_currency_id) {
            $query->where('quote_currency_id', $quote_currency_id);
        })->when($base_currency_id > 0, function ($query) use ($base_currency_id) {
            $query->where('base_currency_id', $base_currency_id);
        })->when($uid != '', function ($query) use ($uid) {
            $query->whereHas('user', function ($query) use ($uid) {
                $query->where('uid', $uid);
            });
        })->when($email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->when($mobile, function ($query, $mobile) {
            $query->whereHas('user', function ($query) use ($mobile) {
                $query->where('mobile', $mobile);
            });
        })->when($type > 0, function ($query) use ($type) {
            $query->where('type', $type);
        })->when($status <> -1, function ($query) use ($status) {
            $query->where('status', $status);
        })->when($start_time != '', function ($query) use ($start_time) {
            $query->where('create_time', '>=', strtotime($start_time));
        })->when($end_time != '', function ($query) use ($end_time) {
            $query->where('create_time', '<=', strtotime($end_time));
        })->orderBy('id', 'desc')
            ->paginate($limit);

        $order_list->each(function($order){
            $order->append('uid','symbol');
        });


        //爆仓价和盈亏比
        foreach ($order_list as $k=>$v){
            $user_wallet = LeverAccount::where('currency_id', $v['quote_currency_id'])
                ->where('user_id', $v['user_id'])
                ->first();

            if($v['type'] == 1){
                $order_list[$k]['explode'] = $v['price'] - abs(LeverUStandard::getAccountAllBalance($user_wallet) / $v['caution_money']);
            }else{
                $order_list[$k]['explode'] = $v['price'] + abs(LeverUStandard::getAccountAllBalance($user_wallet) / $v['caution_money']);
            }

            $order_list[$k]['profit_bi'] = round($v['profits'] / $v['caution_money'],4) * 100 ."%";

        }

        return $this->layuiPageData($order_list);
    }

    //导出合约交易 团队所有订单excel
    public function csv(Request $request)
    {

        //        $limit = $request->input("limit", "");
        $id = $request->input("id", 0);
        $username = $request->input("phone", '');
        $status = $request->input("status", 10);
        $type = $request->input("type", 0);

        $start = $request->input("start", '');
        $end = $request->input("end", '');
        //        var_dump($id);die;
        $where = [];
        if ($id > 0) {
            $where[] = ['lever_u_standard_history.id', '=', $id];
        }
        //        var_dump($where);die;
        if (!empty($username)) {
            $s = DB::table('users')->where('account_number', $username)->first();
            if ($s !== null) {
                $where[] = ['lever_u_standard_history.user_id', '=', $s->id];
            }
        }

        if ($status != -1 && in_array($status, [LeverUStandard::STATUS_ENTRUST, LeverUStandard::WAY_BUY, LeverUStandard::STATUS_CLOSED, LeverUStandard::STATUS_CANCEL, LeverUStandard::STATUS_CLOSING])) {
            $where[] = ['lever_u_standard_history.status', '=', $status];
        }

        if ($type > 0 && in_array($type, [1, 2])) {
            $where[] = ['type', '=', $type];
        }
        if (!empty($start) && !empty($end)) {
            $where[] = ['lever_transaction.create_time', '>', strtotime($start . ' 0:0:0')];
            $where[] = ['lever_transaction.create_time', '<', strtotime($end . ' 23:59:59')];
        }

        $order_list = LeverUStandardHistory::leftjoin("users", "lever_u_standard_history.user_id", "=", "users.id")
            ->select("lever_u_standard_history.*", "users.phone")
            ->whereIn('lever_u_standard_history.status', [
                LeverUStandard::STATUS_ENTRUST,
                LeverUStandard::WAY_BUY,
                LeverUStandard::STATUS_CLOSED,
                LeverUStandard::STATUS_CANCEL,
                LeverUStandard::STATUS_CLOSING
                ])
            ->where($where)
            ->get();

        foreach ($order_list as $key => $value) {
            $order_list[$key]["create_time"] = date("Y-m-d H:i:s", $value->create_time);
            $order_list[$key]["transaction_time"] = date("Y-m-d H:i:s", substr($value->transaction_time, 0, strpos($value->transaction_time, '.')));
            $order_list[$key]["update_time"] = date("Y-m-d H:i:s", substr($value->update_time, 0, strpos($value->update_time, '.')));
            $order_list[$key]["handle_time"] = date("Y-m-d H:i:s", substr($value->handle_time, 0, strpos($value->handle_time, '.')));
            $order_list[$key]["complete_time"] = date("Y-m-d H:i:s", substr($value->complete_time, 0, strpos($value->complete_time, '.')));
        }

        $data = $order_list;

        return Excel::create('合约交易', function ($excel) use ($data) {
            $excel->sheet('合约交易', function ($sheet) use ($data) {
                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('ID');
                });
                $sheet->cell('B1', function ($cell) {
                    $cell->setValue('用户名');
                });
                $sheet->cell('C1', function ($cell) {
                    $cell->setValue('交易手续费');
                });
                $sheet->cell('D1', function ($cell) {
                    $cell->setValue('隔夜费金额');
                });
                $sheet->cell('E1', function ($cell) {
                    $cell->setValue('交易类型');
                });
                $sheet->cell('F1', function ($cell) {
                    $cell->setValue('当前状态');
                });
                $sheet->cell('G1', function ($cell) {
                    $cell->setValue('原始价格');
                });
                $sheet->cell('H1', function ($cell) {
                    $cell->setValue('开仓价格');
                });
                $sheet->cell('I1', function ($cell) {
                    $cell->setValue('当前价格');
                });



                $sheet->cell('J1', function ($cell) {
                    $cell->setValue('手数');
                });
                $sheet->cell('K1', function ($cell) {
                    $cell->setValue('倍数');
                });
                $sheet->cell('L1', function ($cell) {
                    $cell->setValue('初始保证金');
                });
                $sheet->cell('M1', function ($cell) {
                    $cell->setValue('当前可用保证金');
                });
                $sheet->cell('N1', function ($cell) {
                    $cell->setValue('创建时间');
                });
                $sheet->cell('O1', function ($cell) {
                    $cell->setValue('价格刷新时间');
                });
                $sheet->cell('P1', function ($cell) {
                    $cell->setValue('平仓时间');
                });
                $sheet->cell('Q1', function ($cell) {
                    $cell->setValue('完成时间');
                });

                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        if ($value['type'] == 1) {
                            $value['type'] = "买入";
                        } else {
                            $value['type'] = "卖出";
                        }
                        if ($value['status'] == 0) {
                            $value['status'] = "挂单中";
                        } elseif ($value['status'] == 1) {
                            $value['status'] = "交易中";
                        } elseif ($value['status'] == 2) {
                            $value['status'] = "平仓中";
                        } elseif ($value['status'] == 3) {
                            $value['status'] = "已平仓";
                        } elseif ($value['status'] == 4) {
                            $value['status'] = "已撤单";
                        }

                        $i = $key + 2;
                        $sheet->cell('A' . $i, $value['id']);
                        $sheet->cell('B' . $i, $value['phone']);
                        $sheet->cell('C' . $i, $value['trade_fee']);
                        $sheet->cell('D' . $i, $value['overnight_money']);
                        $sheet->cell('E' . $i, $value['type']);
                        $sheet->cell('F' . $i, $value['status']);
                        $sheet->cell('G' . $i, $value['origin_price']);
                        $sheet->cell('H' . $i, $value['price']);
                        $sheet->cell('I' . $i, $value['update_price']);

                        $sheet->cell('J' . $i, $value['share']);
                        $sheet->cell('K' . $i, $value['multiple']);
                        $sheet->cell('L' . $i, $value['origin_caution_money']);
                        $sheet->cell('M' . $i, $value['caution_money']);
                        $sheet->cell('N' . $i, $value['create_time']);
                        $sheet->cell('O' . $i, $value['update_time']);
                        $sheet->cell('P' . $i, $value['handle_time']);
                        $sheet->cell('Q' . $i, $value['complete_time']);
                    }
                }
            });
        })->download('xlsx');
    }

    /**
     * 后台强制平仓
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function close(Request $request)
    {
        $id = $request->get("id");
        if (empty($id)) {
            return $this->error("参数错误");
        }

        DB::beginTransaction();
        try {
            $lever_transaction = LeverUStandard::lockForupdate()->find($id);
            if (empty($lever_transaction)) {
                throw new Exception("数据未找到");
            }

            if ($lever_transaction->status != LeverUStandard::STATUS_TRANSACTION) {
                throw new Exception("交易状态异常,请勿重复提交");
            }

            $log_type = LeverUStandard::CLOSED_BY_STOP_LOSS;

            if($lever_transaction->profits >= 0){

                $log_type = LeverUStandard::CLOSED_BY_TARGET_PROFIT;
            }

//            $return = LeverTransaction::leverClose($lever_transaction, LeverTransaction::CLOSED_BY_ADMIN);
            $return = LeverUStandard::leverClose($lever_transaction, $log_type);
            if (!$return) {
                throw new Exception("平仓失败,请重试");
            }
            DB::commit();
            return $this->success("操作成功");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function dealClosing(Request $request): JsonResponse
    {
        $id = $request->get("id");
        if (empty($id)) {
            return $this->error("参数错误");
        }

        $lever_transaction = LeverUStandard::lockForupdate()->find($id);
        try {
            DB::beginTransaction();
            if (empty($lever_transaction)) {
                throw new \Exception(__('model.交易不存在'));
            }

             if ($lever_transaction->status != LeverUStandard::STATUS_CLOSING) {
                 throw new \Exception('该笔交易状态异常,不能平仓' . $lever_transaction->status);
             }

            $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
//            $legal_wallet = Account::getAccountByType(AccountType::CHANGE_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);

            if (empty($legal_wallet)) {
                throw new \Exception(__('model.钱包不存在'));
            }
            $profit = $lever_transaction->profits;
            $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
            $pre_result = bc($legal_wallet->balance, '+', $change);
            $diff = 0;

            $extra_data = [
                'trade_id' => $lever_transaction->id,
                'caution_money' => $lever_transaction->caution_money,
                'profit' => $profit,
                'diff' => $diff,
                'mome' => '平仓资金处理',
                'strict' => false
            ];
            $legal_wallet->changeBalance(AccountLog::LEVER_TRANSACTION_ADD, $change, $extra_data);

            $lever_transaction->refresh();
            $lever_transaction->status = LeverUStandard::STATUS_CLOSED;
            $lever_transaction->fact_profits = $profit;
            $lever_transaction->complete_time = microtime(true);
            $lever_transaction->closed_type = LeverUStandard::CLOSED_BY_USER_SELF; //平仓类型
            $result = $lever_transaction->save();
            if (!$result) {
                throw new \Exception(__('model.平仓失败:更新处理状态失败'));
            }
            DB::commit();
            $lever_trades = collect([$lever_transaction]);
            event(new UStandardClosedEvent($lever_trades));

            return $this->success("操作成功");

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }


    }
}
