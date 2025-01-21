<?php


namespace App\Models\Iso;

use App\Console\Commands\IsoLever\Worker;
use App\Jobs\IsoLeverClosed;
use App\Models\Account\AccountLog;
use App\Models\Account\IsoAccount;
use App\Models\Currency\CurrencyMatch;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Lever\LeverTransaction;
use App\Models\Model;
use App\Models\User\User;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class IsoLever
 *
 * @property  CurrencyMatch $currencyMatch
 *
 * @package App\Models\Iso
 */
class IsoLever extends Model
{
    //交易方向
    const TYPE_BUY = 1;
    const TYPE_SELL = 2;

    //交易状态
    const STATUS_WAIT = 1;                                                                                                                                                                                                                                                                                                                                                                                                                            //挂单中
    const STATUS_TX = 2;                                                                                                                                                                                                                                                                                                                                                                                                                            //交易中
    const STATUS_CANCEL = 3;                                                                                                                                                                                                                                                                                                                                                                                                                            //交易中
    const STATUS_CLOSING = 4;                                                                                                                                                                                                                                                                                                                                                                                                                            //平仓中
    const STATUS_CLOSED = 5;                                                                                                                                                                                                                                                                                                                                                                                                                            //已平仓

    //平仓方式
    const CLOSE_USER = 1;                                                                                                                                                                                                                                                                                                                                                                                                                                //用户平仓
    const CLOSE_ADMIN = 2;                                                                                                                                                                                                                                                                                                                                                                                                                               //管理员平仓
    const CLOSE_STOP_PROFIT = 3;                                                                                                                                                                                                                                                                                                                                                                                                                         //止盈
    const CLOSE_STOP_LOSS = 4;                                                                                                                                                                                                                                                                                                                                                                                                                         //止损
    const CLOSE_BOOM = 5;                                                                                                                                                                                                                                                                                                                                                                                                                         //爆仓

    protected $appends = [
        'type_name',
        'closed_type_name',
        'status_name',
    ];

    protected $dates = [
        'type_name',
        'close_at',
        'cancel_at',
    ];

    public function getTypeNameAttribute()
    {
        $name[self::TYPE_BUY] = __('model.买入');
        $name[self::TYPE_SELL] = __('model.卖出');
        return $name[$this->getAttribute('type')] ?? '-/-';
    }

    public function getNowProfitsAttribute()
    {
        if ($this->status == self::STATUS_CLOSED) {
            return $this->fact_profits;
        }
        $close = $this->currencyMatch->getLastPrice();
        return $this->getProfit($close);
    }

    public function getStatusNameAttribute()
    {
        $name[self::STATUS_WAIT] = __('model.挂单中');
        $name[self::STATUS_TX] = __('model.交易中');
        $name[self::STATUS_CANCEL] = __('model.已撤单');
        $name[self::STATUS_CLOSED] = __('model.已平仓');
        $name[self::STATUS_CLOSING] = __('model.平仓中');
        return $name[$this->getAttribute('status')] ?? '-/-';
    }

    public function getClosedTypeNameAttribute()
    {
        $name[self::CLOSE_BOOM] = __('model.爆仓');
        $name[self::CLOSE_ADMIN] = __('model.管理员');
        $name[self::CLOSE_STOP_PROFIT] = __('model.止盈');
        $name[self::CLOSE_STOP_LOSS] = __('model.止损');
        $name[self::CLOSE_USER] = __('model.平仓');
        return $name[$this->getAttribute('closed_type')] ?? '-/-';
    }

    public function getUidAttribute()
    {
        return $this->user->uid ?? '-/-';
    }

    public function getSymbolAttribute()
    {
        return $this->currencyMatch->symbol ?? '-/-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currencyMatch()
    {
        return $this->belongsTo(CurrencyMatch::class);
    }

    public function setOriginPriceAttribute($price)
    {
        $origin_price = $price;
        if ($this->type == IsoLever::TYPE_BUY) {
            $price += $this->currencyMatch()->value('lever_point_rate') * $price;
        } elseif ($this->type == IsoLever::TYPE_SELL) {
            $price -= $this->currencyMatch()->value('lever_point_rate') * $price;
        }
        $this->attributes['origin_price'] = $origin_price;
        $this->attributes['fact_price'] = $price;
    }

    public function setShareAttribute($share)
    {
        $number = $this->currencyMatch()->value('lever_share_num') * $share;
        $this->attributes['share'] = $share;
        $this->attributes['number'] = $number;
    }

    /**
     * @param int $currency_match_id 交易对id
     * @param float $price 为零就是市价交易
     * @param int $share 手数
     * @param int $multiple 倍数
     * @param int $type 交易方向
     * @param int $status 交易类型[市价,限价]
     *
     * @return IsoLever|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     * @throws \Throwable
     */
    public static function submit($currency_match_id, $price, $share, $multiple, $type)
    {
        $user = User::getUser();
        $currencyMatch = CurrencyMatch::find($currency_match_id);
        if (!$currencyMatch->open_iso) {
            throw new \Exception(__('api.交易对未开启逐仓合约'));
        }
        $last_price = $currencyMatch->getLastPrice();

        if ($price != 0) {
            $status = self::STATUS_WAIT;
            if ($type == self::TYPE_SELL && $price <= $last_price) {
                throw new \Exception(__('api.限价交易卖出不能低于当前价'));
            }
            if ($type == self::TYPE_BUY && $price >= $last_price) {
                throw new \Exception(__('api.限价交易买入价格不能高于当前价'));
            }
        } else {
            $price = $last_price;
            $status = self::STATUS_TX;
        }
        throw_if($price <= 0, new \Exception(__('api.行情价获取失败')));

        $isoLever = new IsoLever([
            'currency_match_id' => $currencyMatch->id,
            'user_id' => $user->id,
            'share' => $share,
            'multiple' => $multiple,
            'type' => $type,
            'origin_price' => $price,
            'transacted_at' => now(),
            'overnight' => $currencyMatch->lever_overnight_fee_rate ?? 0,
            'agent_path' => $user->agent_path,
            'status' => $status,
        ]);
        //计算爆仓价并保存
        $isoLever->cautionMoneyAndFee()->computeBoomPrice()->save();
        return $isoLever;
    }

    /**同步到worker进程
     *
     * @return $this;
     * @throws GuzzleException
     */
    public function syncToWorker()
    {
        $res = Worker::http(Worker::METHOD_ORDER, [
            'id' => $this->id
        ]);
        if (!$res['code']) {
            throw new \Exception($res['msg']);
        }
        return $this;
    }

    /**扣保证金和手续费
     *
     * @return $this
     * @throws \Exception
     */
    public function cautionMoneyAndFee()
    {
        $currencyMatch = $this->currencyMatch();
        //单子价值
        $order_volume = $this->number * $this->fact_price;
        //交易手续费
        $trade_fee = $order_volume * $currencyMatch->value('lever_fee_rate');
        //扣保证金和手续费
        $caution_money = bc($order_volume, '/', $this->multiple); //保证金
        $dec_balance = bc($caution_money, "+", $trade_fee);     //保证金+手续费
        IsoAccount::getAccountForLock($currencyMatch->value('quote_currency_id'), $this->user_id)
            ->changeBalance(AccountLog::ISO_LEVER_SUBMIT, -abs($dec_balance));

        $this->caution_money = $caution_money;
        $this->origin_caution_money = $caution_money;
        $this->trade_fee = $trade_fee;
        return $this;
    }

    /**撤单
     *
     * @throws \Exception
     */
    public function cancel()
    {
        if ($this->status != self::STATUS_WAIT) {
            throw new \Exception(__('model.此状态不能取消'));
        }

        //撤掉保证金和手续费
        $fee = $this->trade_fee;
        $caution_money = $this->caution_money;
        $inc_balance = $fee + $caution_money;

        IsoAccount::getAccountForLock($this->currencyMatch->quote_currency_id, $this->user_id)
            ->changeBalance(AccountLog::ISO_LEVER_CANCEL, $inc_balance);

        $this->status = self::STATUS_CANCEL;
        $this->save();
    }

    /**检查是否应该爆仓
     *
     * @param $price
     *
     * @return bool
     * @throws \Exception
     */
    public function checkBoom($price)
    {
        if ($this->status == self::STATUS_CLOSED) {
            return false;
        }
        //如果保证金亏完就爆仓
        $fact_profit = $this->getProfit($price);
        if (($this->caution_money - abs($fact_profit)) <= 0) {
            $this->close(self::CLOSE_BOOM, $price);
            IsoLeverClosed::dispatch($this)->onQueue('isoLever:close');
            return true;
        }
        return false;
    }

    /**检查是否应该止盈止损
     *
     * @param $price
     *
     * @return bool
     * @throws \Exception
     */
    public function checkStop($price)
    {
        //检查卖出止盈止损
        if ($this->target_profit_price == 0 || $this->stop_loss_price == 0) {
            return false;
        }
        if ($this->type == self::TYPE_SELL && $price <= $this->target_profit_price) {
            $this->close(self::CLOSE_STOP_PROFIT, $price);
            return true;
        }
        if ($this->type == self::TYPE_SELL && $price >= $this->stop_loss_price) {
            $this->close(self::CLOSE_STOP_LOSS, $price);
            return true;
        }
        //检查买入止盈止损
        if ($this->type == self::TYPE_BUY && $price >= $this->target_profit_price) {
            $this->close(self::CLOSE_STOP_PROFIT, $price);
            return true;
        }
        if ($this->type == self::TYPE_BUY && $price <= $this->stop_loss_price) {
            $this->close(self::CLOSE_STOP_LOSS, $price);
            return true;
        }
        return false;
    }

    /**
     * 平仓
     * @param int $type 平仓类型
     * @param $price
     * @throws \Exception
     */
    public function close($type, $price = 0)
    {
        $this->refresh();
        if ($this->status != self::STATUS_TX) {
            throw new \Exception(__('model.此状态不能平仓'));
        }
        $price = $price ?? CurrencyQuotation::where('currency_match_id', $this->currency_match_id)->value('close');
        $profit = $this->getProfit($price);
        $this->closed_type = $type;
        $this->fact_profits = $profit;
        $this->closed_at = now();
        $this->status = self::STATUS_CLOSED;
        $this->save();
        //结算盈亏
        $change_balance = $this->caution_money - $profit;
        if ($change_balance > 0) {
            IsoAccount::getAccountForLock($this->currencyMatch()->value('quote_currency_id'), $this->user_id)
                ->changeBalance(AccountLog::ISO_LEVER_CLOSE, $change_balance);
        }
    }

    /**激活限价单
     *
     * @param $currencyMatch
     * @param $price
     */
    public function checkActive($price)
    {
        if ($this->status != self::STATUS_WAIT) {
            return false;
        }
        if ($this->type == self::TYPE_SELL && $price < $this->fact_price) {
            return false;
        }
        if ($this->type == self::TYPE_BUY && $price > $this->fact_price) {
            return false;
        }
        $this->status = self::STATUS_TX;
        $this->transacted_at = now();
        $this->save();
        return true;
    }

    /**设置止盈止损
     *
     * @param $high
     * @param $low
     *
     * @return $this
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function setStop($target_profit_price, $stop_loss_price)
    {
        $last_price = $this->currencyMatch->getlastPrice();

        if ($this->type == self::TYPE_BUY) {
            //买入
            if ($target_profit_price <= $this->fact_price || $target_profit_price <= $last_price) {
                throw  new \Exception(__('api.买入(做多)止盈价不能低于开仓价和当前价'));
            }
            if ($stop_loss_price >= $this->fact_price || $stop_loss_price >= $last_price) {
                throw  new \Exception(__('api.买入(做多)止亏价不能高于开仓价和当前价'));
            }
        }
        if ($this->type == self::TYPE_SELL) {
            //卖出
            if ($target_profit_price >= $this->fact_price || $target_profit_price >= $last_price) {
                throw  new \Exception(__('api.卖出(做空)止盈价不能高于开仓价和当前价'));
            }
            if ($stop_loss_price <= $this->fact_price || $stop_loss_price <= $last_price) {
                throw  new \Exception(__('api.卖出(做空)止亏价不能低于开仓价和当前价'));
            }
        }

        $this->update([
            'target_profit_price' => $target_profit_price,
            'stop_loss_price' => $stop_loss_price,
        ]);
        Worker::http(Worker::METHOD_UPDATE_ORDER, [
            'id' => $this->id
        ]);
        return $this;
    }

    /**更新爆仓价
     *
     */
    public function computeBoomPrice()
    {
        if ($this->type == IsoLever::TYPE_BUY) {
            $boom_price = $this->fact_price - $this->fact_price / $this->multiple;
        } elseif ($this->type == IsoLever::TYPE_SELL) {
            $boom_price = $this->fact_price + $this->fact_price / $this->multiple;
        }
        $this->boom_price = $boom_price;
        return $this;
    }

    /**扣隔夜费
     *
     */
    public function overnightFee()
    {
        //扣隔夜费后保证金减少,爆仓价也改变
        $fee = $this->overnight * $this->caution_money;
        $this->caution_money -= $fee;
        $this->overnight_money += $fee;
        $this->save();
        return $this;
    }

    public function getProfit($close)
    {
        if ($this->status == self::STATUS_WAIT) {
            return 0;
        }
        if ($close == 0) {
            return 0;
        }
        if ($this->type == self::TYPE_BUY) {
            $profit = bc($close, '-', $this->fact_price, 4);
            return bc($profit, '*', $this->multiple, 4);
        }
        if ($this->type == self::TYPE_SELL) {
            $profit = bc($this->fact_price, '-', $close, 4);
            return $profit;
        }
    }
}
