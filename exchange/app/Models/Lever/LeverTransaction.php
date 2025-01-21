<?php

namespace App\Models\Lever;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Model;
use App\Models\Account\{Account, AccountLog, AccountType, LeverAccount, LeverAccountLog};
use App\Models\User\User;
use App\Models\Currency\{CurrencyQuotation, CurrencyMatch};
use App\Models\Setting\Setting;
use App\Events\Lever\LeverClosedEvent;
use App\Jobs\{DeductBalance, HandleUserLever, LeverClosed, LeverPushTrade, LeverHandle, SendMarket, LeverClosing};
use App\Logic\{ConnectRattleMq, Market, SocketPusher};

class LeverTransaction extends Model
{
    // 下单方向
    const WAY_BUY = 1;                 //买入
    const WAY_SELL = 2;                //卖出

    // 交易状态
    const STATUS_ENTRUST = 0;          //挂单中
    const STATUS_TRANSACTION = 1;      //交易中
    const STATUS_CLOSING = 2;          //平仓中
    const STATUS_CLOSED = 3;           //已平仓
    const STATUS_CANCEL = 4;           //已撤单

    // 平仓原因
    const CLOSED_BY_UNKNOW = 0;        // 未知
    const CLOSED_BY_USER_SELF = 1;     // 用户平仓
    const CLOSED_BY_MARKET_PRICE = 1;  // 市场价平仓
    const CLOSED_BY_OUT_OF_MONEY = 2;  // 暴仓
    const CLOSED_BY_TARGET_PROFIT = 3; // 止盈平仓SendMarket
    const CLOSED_BY_STOP_LOSS = 4;     // 止损平仓
    const CLOSED_BY_ADMIN = 5;         // 后台管理员平仓

    //结算状态
    const NOT_SETTLE = 0;
    const SETTLED = 1;

    protected $table = 'lever_transaction';
    public $timestamps = false;

    protected $appends = [
        //'uid',
        'time',
        //'symbol',
        'profits',
        'status_name',
        'type_name',
        //'mobile',
        //'email'
    ];

    protected static $statusList = [
        '挂单中',
        '交易中',
        '平仓中',
        '已平仓',
        '已撤单',
    ];

    protected static $typeList = [
        '',
        '买入',
        '卖出',
    ];

    protected static $closedTypeList = [
        '',
        '市价',
        '暴仓',
        '止盈',
        '止损',
        '后台',
    ];

    public static function enumStatus()
    {
        return self::$statusList;
    }

    public static function enumClosedType()
    {
        return self::$closedTypeList;
    }

    public function getClosedTypeNameAttribute()
    {
        $closed_type = $this->attributes['closed_type'];
        return array_key_exists($closed_type, self::$closedTypeList) ? self::$closedTypeList[$closed_type] : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function currencyMatch()
    {
        return $this->belongsTo(CurrencyMatch::class);
    }

    public function getMobileAttribute()
    {
        return $this->user->mobile ?? '';
    }

    // public function getUidAttribute()
    // {
    //     return $this->user->uid ?? '';
    // }

    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }

    public function getUidAttribute()
    {
        return $this->user->uid ?? '';
    }

    public function getSymbolAttribute()
    {
        return $this->currencyMatch->symbol ?? __('model.未知');
    }

    public function getStatusNameAttribute()
    {
        $status = $this->attributes['status'] ?? 0;
        return self::$statusList[$status];
    }

    public function getTypeNameAttribute()
    {
        $type = $this->attributes['type'] ?? 0;
        $str = self::$typeList[$type];
        return __("model.{$str}");
    }

    public function getTimeAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['create_time'] ?? 0);
    }

    public function getHandleTimeAttribute()
    {
        $handle_time = intval($this->attributes['handle_time']);
        return $handle_time != 0 ? date('Y-m-d H:i:s', $handle_time) : '';
    }

    public function getTransactionTimeAttribute()
    {
        $transaction_time = intval($this->attributes['transaction_time']);
        return $transaction_time != 0 ? date('Y-m-d H:i:s', $transaction_time) : '';
    }

    public function getCompleteTimeAttribute()
    {
        $complete_time = intval($this->attributes['complete_time']);
        return $complete_time != 0 ? date('Y-m-d H:i:s', $complete_time) : '';
    }

    /**
     * 取每单盈利
     *
     */
    public function getProfitsAttribute()
    {
        $profits = 0;
        $type = $this->getAttribute('type');
        $number = $this->getAttribute('number');
        $status = $this->getAttribute('status');
        if ($status == self::STATUS_ENTRUST || $status == self::STATUS_CANCEL) {
            return 0.00;
        }
        //$multiple = $this->getAttribute('multiple');
        //$multiple_number = bc_mul($number, $multiple);
        $update_price = $this->getAttribute('update_price');
        $price = $this->getAttribute('price');
        $diff = $type == self::WAY_BUY ? bc($update_price, '-', $price) : bc($price, '-', $update_price);
        $profits = bc($diff, '*', $number);
        return $profits;
    }

    public static function leverMultiple($key = 0)
    {
        $data["muit"] = LeverMultiple::where("type", 1)->select("value")->get()->toArray();
        $data["share"] = LeverMultiple::where("type", 2)->select("value")->get()->toArray();
        if (!empty($key) && in_array($key, $data)) {
            return $data[$key];
        } else {
            return $data;
        }
    }

    /**
     * 订单价格更新
     *
     * @param \App\Models\Currency\CurrencyMatch $currency_match 交易对
     * @param float $price 当前交易对最新价格
     * @param float $timestamp 毫秒级时间戳
     *
     * @return void
     */
    public static function newPrice($currency_match, $price, $timestamp = null)
    {
        $timestamp == null && $timestamp = microtime(true);
        if (empty($currency_match) || empty($price)) {
            return false;
        }

        $price = CurrencyQuotation::where('currency_match_id', $currency_match->id)->value('close') ?? $price;

        $params = [
            'currency_match' => $currency_match,
            'now_price' => $price,
            'now' => $timestamp,
        ];
        //先批量更新指定交易对未平仓的交易的最新价格
        LeverTransaction::where("currency_match_id", $currency_match->id)
            ->where("status", '<=', self::STATUS_TRANSACTION)
            ->update([
                'update_price' => $price,
                'update_time' => $timestamp,
            ]);

        //激活满足条件的挂单
        self::entrustActivate();
        //止盈止亏处理
        self::checkNeedStopPriceTrade($currency_match, 0);
//        ConnectRattleMq::publish_send(ConnectRattleMq::$quoteHandleConsume,$params);
//        LeverHandle::dispatch($params)->onQueue('lever:handle');
        // echo '更新持仓订单价格消耗:' . ($end - $start) . '秒' . PHP_EOL;
    }

    /**
     * 价格变动处理逻辑
     *
     * @param \App\Models\Currency\CurrencyMatch $currency_match 交易对
     * @param float|string $price 当前交易对最新价格
     * @param float $timestamp 毫秒级时间戳
     *
     * @return void
     */
    public static function tradeHandle($currency_match, $timestamp = null)
    {
        $lever_users = LeverTransaction::where("currency_match_id", $currency_match->id)
            ->where("status", self::STATUS_TRANSACTION)
            ->select("id", "user_id", "create_time")
            ->groupBy('user_id')
            ->get();

        if (count($lever_users) <= 0) {
            return;
        }

        $sub_user_ids = SocketPusher::getUidListByGroup(SocketPusher::LEVER_TRADE);
        foreach ($lever_users as $lever) {
            //推送风险率和订单
            $user_id = $lever->user_id;
            self::handleUserLever($user_id,$currency_match);
            $params = [
                "user_id"=>$user_id,
                "currency_match"=>$currency_match
            ];
//                if (in_array($user_id, $sub_user_ids)) {
//                    ConnectRattleMq::publish_send(ConnectRattleMq::$leverPushTradeConsume,$params);
//                }

//                $queue_num = $user_id % 10;
//                ConnectRattleMq::publish_send(ConnectRattleMq::$handleUserLeverConsume,$params);
//                HandleUserLever::dispatch($user_id, $currency_match)->onQueue('handle:user:lever:' . $queue_num);

            if (in_array($user_id, $sub_user_ids)) {
                LeverPushTrade::dispatch($lever->user_id, $currency_match)->onQueue('lever:push:trade');
            }

        }
    }

    /**
     * 处理用户指定交易对的合约交易
     *
     * @param integer $user_id 用户id
     * @param \App\Models\Currency\CurrencyMatch $currency_match 交易对
     *
     * @return boolean
     */
    protected static function handleUserLever($user_id, $currency_match)
    {
        if (empty($user_id || empty($currency_match))) {
            return false;
        }
        $quote_currency_id = $currency_match->quote_currency_id;
//        DB::beginTransaction();
        try {
//            $quote_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $quote_currency_id, $user_id);
            $quote_wallet = LeverAccount::where(['user_id' => $user_id,'currency_id' =>$quote_currency_id])->first();

            if (empty($quote_wallet)) {
                throw new \Exception(__('model.钱包不存在'));
            }
            //取交易对总盈利和总保证金
            $profit_results = self::getUserProfit($user_id, $quote_currency_id, 0);
            /**
             * @var $profits_total
             * @var $caution_money_total
             */
            extract($profit_results);
            //是否满足爆仓条件
            $need_burst = self::checkBurst($quote_wallet);
            if (!$need_burst) {
                throw new \Exception(__('model.不满足爆仓条件'));
            }
            //对用户交易对做平仓中标记
            $affect_result = self::setUserLeverCover($user_id, $quote_currency_id, 0, self::CLOSED_BY_OUT_OF_MONEY);
            if (count($affect_result) <= 0) {
                throw new \Exception(__('model.爆仓状态标记失败'));
            }
            $diff = 0;
            $change = bc($profits_total, '+', $caution_money_total);
            $after_balance = bc($quote_wallet->balance, "+", $change);

//            // 如果余额不够扣就抹去不够扣的金额
//            if (bccomp($after_balance, '0') < 0) {
////                $diff = $after_balance;
////                $change = -$quote_wallet->balance + round($quote_wallet->balance *0.02 , 6);
//                $diff = $after_balance;
//                $change = -$quote_wallet->balance;
//            }
            $currency_name = $quote_wallet->currency_name;
            $extra_data = serialize([
                'currency_name' => $currency_name,
                'affect_result' => $affect_result,
                'balance' => $quote_wallet->balance,
                'caution_money_total' => $caution_money_total,
                'profits_total' => $profits_total,
                'diff' => $diff,
            ]);
            $data = [
                'mome' => "暴仓处理{$currency_name}余额(退回保证金:{$caution_money_total},结算总盈亏:{$profits_total})",
                'strict' => false,
                'data' => $extra_data,
            ];

            DeductBalance::dispatch($user_id,$quote_currency_id,LeverAccountLog::LEVER_TRANSACTION_FROZEN, $change, $data)->onQueue('deductBalance');


//            DB::commit();
            $params = [
                "affect_result"=>$affect_result,
                "deduct_balance"=>false
            ];
            return true;
        } catch (\Exception $ex) {
//            echo date('Y-m-d H:i:s') . ' File:' . $ex->getFile() . ', Line:' . $ex->getLine() . ', Message:' . $ex->getMessage() . PHP_EOL;
//            DB::rollBack();
            // $path = base_path() . '/storage/logs/lever/';
            // $filename = date('Ymd') . '.log';
            // file_exists($path) || @mkdir($path);
            // error_log(date('Y-m-d H:i:s') . ' File:' . $ex->getFile() . ', Line:' . $ex->getLine() . ', Message:' . $ex->getMessage() . PHP_EOL, 3, $path . $filename);
            return false;
        }
    }

    /**
     * 取用户盈利和保证金
     *
     * @param integer $user_id 用户id
     * @param integer $quote_currency_id 计价币id
     * @param integer $base_currency_id 交易币id
     *
     * @return array
     */
    public static function getUserProfit($user_id, $quote_currency_id = 0, $base_currency_id = 0)
    {
        $profits_total = '0';              //交易对盈亏总额
        $caution_money_total = '0';        //交易对可用本金总额
        $origin_caution_money_total = '0'; //交易对原始保证金
        try {
            //优先让数据库计算盈亏和保证金
            $user_profit = LeverTransaction::where('status', self::STATUS_TRANSACTION)
                ->where('user_id', $user_id)
                ->where(function ($query) use ($quote_currency_id, $base_currency_id) {
                    $base_currency_id > 0 && $query->where('base_currency_id', $base_currency_id);
                    $quote_currency_id > 0 && $query->where('quote_currency_id', $quote_currency_id);
                })
                ->select('user_id')
                ->selectRaw('SUM((CASE `type` WHEN 1 THEN `update_price` - `price` WHEN 2 THEN `price` - `update_price` END) * `number`) AS `profits_total`')
                ->selectRaw('SUM(`caution_money`) AS `caution_money_total`')
                ->selectRaw('SUM(`origin_caution_money`) AS `origin_caution_money_total`')
                ->groupBy('user_id')
                ->first();
            if (!$user_profit) {
                $levers = LeverTransaction::where(function ($query) use ($base_currency_id, $quote_currency_id) {
                    $base_currency_id > 0 && $query->where("base_currency_id", $base_currency_id);
                    $quote_currency_id > 0 && $query->where("quote_currency_id", $quote_currency_id);
                })->where("user_id", $user_id)->where("status", self::STATUS_TRANSACTION)->get();
                if (count($levers) <= 0) {
                    throw new \Exception(__('model.没有需要处理的交易'));
                }
                //计算交易对总盈亏
                foreach ($levers as $trade) {
                    $caution_money_total = bc($caution_money_total, '+', $trade->caution_money);
                    $origin_caution_money_total = bc($origin_caution_money_total, '+', $trade->origin_caution_money);
                    $profits_total = bc($profits_total, '+', $trade->profits);
                }
            } else {
                $caution_money_total = $user_profit->caution_money_total;
                $origin_caution_money_total = $user_profit->origin_caution_money_total;
                $profits_total = $user_profit->profits_total;
            }
        } catch (\Exception $e) {
            //echo $e->getMessage();
        }
        return [
            'profits_total' => $profits_total,
            'caution_money_total' => $caution_money_total,
            'origin_caution_money_total' => $origin_caution_money_total,
        ];
    }

    /**
     * 平仓用户指定交易对交易(只是改变状态,避免价格再被更新)
     *
     * @param integer $user_id
     * @param integer $quote_currency_id
     * @param integer $base_currency_id
     *
     * @return array
     */
    protected static function setUserLeverCover($user_id, $quote_currency_id = 0, $base_currency_id = 0, $closed_type = 0)
    {
//        DB::beginTransaction();
        $trades = LeverTransaction::where(function ($query) use ($quote_currency_id, $base_currency_id) {
            $quote_currency_id > 0 && $query->where("quote_currency_id", $quote_currency_id);
            $base_currency_id > 0 && $query->where("base_currency_id", $base_currency_id);
        })->where("user_id", $user_id)->where("status", self::STATUS_TRANSACTION);
        $list = $trades->pluck('id')->all(); //记录下标记的交易id
        $result = $trades->update([
            'closed_type' => $closed_type,
            'status' => self::STATUS_CLOSING,
            'handle_time' => microtime(true),
        ]);
//        DB::commit();
        return $result > 0 ? $list : [];
    }

    /**
     * 平仓
     *
     * @param \App\Models\Lever\LeverTransaction $lever_transaction
     * @param integer $closed_type 平仓类型
     *
     * @return bool
     * @throws \Exception
     */
    public static function leverClose($lever_transaction, $closed_type = self::CLOSED_BY_USER_SELF,$uPrice = 0)
    {

        try {
            DB::beginTransaction();
            if (empty($lever_transaction)) {
                throw new \Exception(__('model.交易不存在'));
            }

            if ($uPrice == 0 ){

                $last_price = $lever_transaction->currencyMatch->getLastPrice();

            }else{

                $last_price = $uPrice;
            }

            $lever_transaction->refresh();
            // if ($lever_transaction->status != self::STATUS_TRANSACTION) {
            //     throw new \Exception('该笔交易状态异常,不能平仓' . $lever_transaction->status);
            // }
            //更新状态
            $lever_transaction->update_price = $last_price;
            $lever_transaction->update_time = microtime(true);
            $lever_transaction->status = self::STATUS_CLOSING;
            $lever_transaction->handle_time = microtime(true);
            $result = $lever_transaction->save();
            if (!$result) {
                throw new \Exception(__('model.平仓失败:锁定交易状态失败'));
            }

            $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
//            $legal_wallet = Account::getAccountByType(AccountType::CHANGE_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);

            if (empty($legal_wallet)) {
                throw new \Exception(__('model.钱包不存在'));
            }

            //计算盈亏
            $profit = $lever_transaction->profits;
            $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
            //从钱包处理资金
            $pre_result = bc($legal_wallet->balance, '+', $change);
            $diff = 0;

            // 是否余额不够扣除
//            if (bccomp($pre_result, 0) < 0) {
//                $change = -$legal_wallet->balance;
//                $diff = $pre_result;
//            }

            $log_type = AccountLog::LEVER_TRANSACTION_ADD;
            if (bccomp($pre_result, 0) < 0) {

                $log_type = AccountLog::LEVER_TRANSACTION_FROZEN;
            }

            $extra_data = [
                'trade_id' => $lever_transaction->id,
                'caution_money' => $lever_transaction->caution_money,
                'profit' => $profit,
                'diff' => $diff,
                'mome' => '平仓资金处理',
                'strict' => false
            ];
            $legal_wallet->changeBalance($log_type, $change, $extra_data);

            $lever_transaction->refresh();
            $lever_transaction->status = self::STATUS_CLOSED;
            $lever_transaction->fact_profits = $profit;
            $lever_transaction->complete_time = microtime(true);
            $lever_transaction->closed_type = $closed_type; //平仓类型
            $result = $lever_transaction->save();
            if (!$result) {
                throw new \Exception(__('model.平仓失败:更新处理状态失败'));
            }
            DB::commit();
            $lever_trades = collect([$lever_transaction]);
            event(new LeverClosedEvent($lever_trades));

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * 取钱包的风险率(请传法币钱包)
     *
     * @param \App\Models\Account\LeverAccount $account
     *
     * @return float
     */
    public static function getAccountHazardRate($account)
    {
        $hazard_rate = 0;
        $total_money = 0;
        if (!$account) {
            return $hazard_rate;
        }
        $profit_result = self::getUserProfit($account->user_id, $account->currency_id);
        /**
         * @var $origin_caution_money_total
         * @var $profits_total
         */
        extract($profit_result);
        $account->refresh();
        $balance = $account->balance;
        $total_money = bc($balance, '+', $origin_caution_money_total);
        if (bc($origin_caution_money_total, '<>', '0')) {
            $hazard_rate = bc(bc(bc($total_money, '+', $profits_total), '/', $origin_caution_money_total), '*', 100, 2);
        }
        return $hazard_rate;
    }

    /**
     * 检测是否达到爆仓条件
     *
     * @param \App\Models\Account\LeverAccount $user_account
     *
     * @return bool 达到返回真，否则返回假
     */
    public static function checkBurst($user_account)
    {
        try {

            //取交易对总盈利和总保证金
//            $profit_results = self::getUserProfit($user_account->user_id, $user_account->currency_id);
//            extract($profit_results);
//            //判断盈亏
//            if (bccomp($profits_total, '0') >= 0) {
//                throw new \Exception(__('model.不存在亏损,无须平仓'));
//            }
//            $change = bcadd($profits_total, $caution_money_total);
//            //如果本金足以抵亏就返回
//            if (bccomp($change, '0') >= 0) {
//                throw new \Exception(__('model.本金充足,无须平仓'));
//            }
//            //本金亏完,判断余额是否够扣,够直接返回
//            //直接判断总额
//            $total_money = bcadd($legal_wallet->lever_balance, $caution_money_total);
//            $pre_total_checked = bcadd($total_money, $profits_total);
//            if (bccomp($pre_total_checked, '0') > 0) {
//                throw new \Exception(__('model.总资金充足,无须平仓'));
//            }

            //使用风控率来控制爆仓
            $lever_burst_hazard_rate = Setting::getValueByKey('lever_burst_hazard_rate', 0);
            $hazard_rate = self::getAccountHazardRate($user_account);
            $result = bc($hazard_rate, '<=', $lever_burst_hazard_rate);
            $param = [
                'hazard_rate' => $hazard_rate,
                'lever_burst_hazard_rate' => $lever_burst_hazard_rate,
            ];

            // $path = base_path() . '/storage/logs/lever/';
            // $filename = date('Ymd') . '.log';
            // file_exists($path) || @mkdir($path);
            // error_log(date('Y-m-d H:i:s') . ' result: ' . var_export($result, true) . ', param:' . var_export($param, true) . PHP_EOL, 3, $path . $filename);
            return $result;
        } catch (\Exception $e) {
            $path = base_path() . '/storage/logs/lever/';
            $filename = date('Ymd') . '.log';
            file_exists($path) || @mkdir($path);
            error_log(date('Y-m-d H:i:s') . ' File:' . $e->getFile() . ', Line:' . $e->getLine() . ', Message:' . $e->getMessage() . PHP_EOL, 3, $path . $filename);
            return false;
        }
    }


    /**
     * 取设置了止盈止亏价并且价格满足的交易
     *
     * @param \App\Models\Currency\CurrencyMatch $currency_match 交易对
     * @param integer $user_id 用户id
     *
     * @return void
     */
    public static function checkNeedStopPriceTrade($currency_match, $user_id = 0)
    {
        /**
         * 关于止盈止亏：
         * 1.买入:当前行情价格【大于等于】“止盈价”时，触发止盈;当前行情价格【小于等于】“止亏价”时，触发止亏;
         * 2.买入:当前行情价格【小于等于】“止盈价”时，触发止盈;当前行情价格【大于等于】“止亏价”时，触发止亏;
         */
        DB::beginTransaction();

        $need_check_lever = LeverTransaction::where('status', self::STATUS_TRANSACTION)
            ->where(function ($query) use ($user_id, $currency_match) {
                $user_id > 0 && $query->where('user_id', $user_id);
                $currency_match && $query->where('currency_match_id', $currency_match->id);
            })->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('type', self::WAY_BUY)->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereRaw('`update_price` >= `target_profit_price`')->where('target_profit_price', '>', 0);
                        })->orWhere(function ($query) {
                            $query->whereRaw('`update_price` <= `stop_loss_price`')->where('stop_loss_price', '>', 0);
                        });
                    });
                })->orWhere(function ($query) {
                    $query->where('type', self::WAY_SELL)->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereRaw('`update_price` <= `target_profit_price`')->where('target_profit_price', '>', 0);
                        })->orWhere(function ($query) {
                            $query->whereRaw('`update_price` >= `stop_loss_price`')->where('stop_loss_price', '>', 0);
                        });
                    });
                });
            });
        $task_list = $need_check_lever->pluck('id')->all();
        // 标注上平仓类型
        $need_check_lever->get()->each(function ($item) {
            if ($item->profits > 0) {
                $item->closed_type = self::CLOSED_BY_TARGET_PROFIT;
            } else {
                $item->closed_type = self::CLOSED_BY_STOP_LOSS;
            }
            $item->save();
        });
        $result = $need_check_lever->update([
            'status' => self::STATUS_CLOSING,
            'handle_time' => microtime(true),
        ]);
        DB::commit();
//        $result > 0 && LeverClosing::dispatch($task_list, true)->onQueue('lever:close');

//        if($result > 0){
//
//            $params = [
//                "affect_result"=>$task_list,
//                "deduct_balance"=>true
//            ];
//            ConnectRattleMq::publish_send(ConnectRattleMq::$leverCloseConsume,$params);
//        }

    }

    /**
     * 委托激活
     *
     * @return void
     */
    public static function entrustActivate()
    {
        /*
        逻辑:分析师认为当价格走到某个区间后会停止,然后逆向走,在停止时期进行反向投资来赚取利润
        例如:
        (1)用户认为某个币在指定周期内跌到5元已跌到谷底不可能再跌了,预测接下来行情会上涨,那应该设定在跌到5元时进行买入,等行情上涨赚钱
        (2)用户认为某个币在指定周期内涨到1000元已经达到顶峰,预测接下来行情会下跌,那应该设定在涨到1000元时进行卖出,等行情下跌赚钱
        程序逻辑:
        (1)卖出:当前价格 [大于等于] 设置价格时触发(等涨到指定价格时卖出坐等下跌)
        (2)买入:当前价格 [小于等于] 设置价格时触发(等跌到指定价格时买入坐等上涨)
        */
        /*
        SELECT *
        FROM lever_transaction
        WHERE
        `status`=0
        AND
        (
        `type`=1 AND `update_price` <= `origin_price`
        OR
        `type`=2 AND `update_price` >= `origin_price`
        )
        */
        $trades = LeverTransaction::where('status', LeverTransaction::STATUS_ENTRUST)
            ->where(function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('type', LeverTransaction::WAY_BUY)
                        ->whereRaw('`update_price` <= `origin_price`');
                })->orWhere(function ($query) {
                    $query->orWhere('type', LeverTransaction::WAY_SELL)
                        ->whereRaw('`update_price` >= `origin_price`');
                });
            });
        $lists = $trades->pluck('id')->all();
        $result = $trades->update([
            'transaction_time' => microtime(true),
            'status' => LeverTransaction::STATUS_TRANSACTION,
        ]);
        return $result > 0 ? $lists : [];
    }

    /**
     * 向前台推送已经删除的合约订单(已平仓的、已撤单的)
     *
     * @param Collection $lever_trades
     *
     * @return void
     */
    public static function pushDeletedTrade(Collection $lever_trades)
    {
        $grouped = $lever_trades->groupBy('user_id');
        $grouped->each(function (Collection $item, $key) {

            //推送深度
            SocketPusher::leverClosed($item->pluck('id')->all(), $key);
        });
    }

    //
    public function getParentAgentNameAttribute()
    {
        $user = $this->user()->getResults();
        return $user ? $user->parent_agent_name : '';
    }

    public function getUserAgentLevelAttribute()
    {

        $user = $this->user()->getResults();
        return $user ? $user->my_agent_level : __('model.普通用户');
    }
}
