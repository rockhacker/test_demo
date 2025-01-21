<?php


namespace App\Models\Account;

use App\Models\Currency\Currency;
use App\Models\Model;
use App\Models\User\User;

abstract class AccountLog extends Model
{

    const IS_LOCK = 1;
    const NO_LOCK = 0;

    const BLOCK_CHAIN_ADD = [1, '链上充值到账'];
    const WITHDRAW = [2, '申请提币'];
    const WITHDRAW_BACK = [3, '提币驳回'];
    const WITHDRAW_CONFIRM = [4, '提币确认'];
    const ACTIVITY_REG_FIRST = [6, '首充有礼'];

    const ADMIN_CHANGE = [10, '管理员调节'];

    const LEGAL_POST_DEAL = [11, '发布法币交易'];
    const LEGAL_POST_CANCEL = [12, '取消发布'];
    const LEGAL_USER_SELL_MATCH = [13, '用户卖出匹配'];
    const LEGAL_DETAIL_CONFIRM = [14, '确认收款'];
    const LEGAL_DETAIL_CANCEL = [15, '用户取消交易'];
    const LEGAL_DETAIL_COMPLETE = [16, '法币交易完成'];

    const TX_CREATE = [20, '币币交易挂单'];
    const TX_MATCH = [21, '币币交易订单成交'];
    const TX_CANCEL = [22, '币币交易订单取消'];
    const TX_COMPLETE = [23, '返还币币交易差价'];

    const LEVER_TRANSACTION = [30, '合约保证金'];
    const LEVER_TRANSACTION_FEE = [31, '合约手续费'];
    const LEVER_TRANSACTION_ADD = [32, '合约平仓'];
    const LEVER_TRANSACTION_FEE_CANCEL = [33, '合约手续费撤回'];
    const LEVER_TRANSACTION_CANCEL = [34, '合约交易保证金撤回'];
    const LEVER_TRANSACTION_FROZEN = [35, '合约爆仓冻结'];
    const LEVER_TRANSACTION_OVERNIGHT = [36, '合约隔夜费'];

    const ISO_LEVER_SUBMIT = [40, '逐仓合约下单'];
    const ISO_LEVER_CLOSE = [41, '逐仓合约平仓'];
    const ISO_LEVER_CANCEL = [42, '逐仓合约撤单'];
    const ISO_LEVER_OVERNIGHT = [43, '逐仓合约隔夜费'];

    const ACCOUNT_TRANSFER_OUT = [50, "账户划出"];
    const ACCOUNT_TRANSFER_IN = [51, "账户划入"];

    const AGENT_JIE_TC_MONEY = [60, "代理商结算头寸"];
    const AGENT_JIE_SX_MONEY = [61, "代理商结算手续费"];

    const MICRO_TRADE_ORDER = [100, '交割下单'];
    const MICRO_TRADE_ORDER_FEE = [101, '交割下单手续费'];
    const MICRO_TRADE_ORDER_CLOSE = [102, '交割平仓'];

    const LEVER_FEE_AGENT_CHANGE = [110, '代理商合约手续费结算'];
    const LEVER_LOSS_AGENT_CHANGE = [111, '代理商合约头寸结算'];
    const MICRO_FEE_AGENT_CHANGE = [112, '代理商交割手续费结算'];
    const MICRO_LOSS_AGENT_CHANGE = [113, '代理商交割头寸结算'];

    const TX_IN_MATCH_SUB = [114,'币币交易购买，减少'];
    const TX_IN_MATCH_ADD = [115,'币币交易购买，增加'];
    const TX_IN_MATCH_FEE = [118,'币币交易购买，扣手续费'];

    const LOCK_SHARE = [210,'募集锁定'];
    const LOCK_CANCEL_SHARE = [210,'取消认购'];
    const SUB_INTEREST = [211,'锁仓收益'];
    const SUB_PRINCIPAL = [212,'认购本金退还'];
    const SUB_PRINCIPAL_INTEREST = [215,'本金和利息退还'];

    const SUB_LIQUIDATED_DAMAGES = [214,'扣除违约金'];
//    const FUND_COMMISSION = [213,'生息返佣'];

//
    const OPTION_TRADE_ORDER = [220, '期权合约下单'];
    const OPTION_TRADE_ORDER_FEE = [221, '期权下单手续费'];
    const OPTION_TRADE_ORDER_CLOSE = [222, '期权平仓'];

    const EXCHANGE_DEP = [119, '兑换扣除'];
    const EXCHANGE_INC = [120, '兑换增加'];


    const SUBSCRIPTION_DEP = [301, '申购扣除'];
    const SUBSCRIPTION_REF = [302, '申购退款'];
    const ISSUED_COINS = [303, '中签发币'];

    protected $appends = [
        'is_lock_name'
    ];

    public function getExtraDataAttribute($value)
    {
        return unserialize($value);
    }

    public function setExtraDataAttribute($value)
    {
        $value = serialize($value);
        $this->attributes['extra_data'] = $value;
    }

    public function getIsLockNameAttribute()
    {
        $value = $this->getAttribute('is_lock');
        $name[0] = __('model.否');
        $name[1] = __('model.是');
        return $name[$value] ?? __('model.未知');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getMemoAttribute($value)
    {
        $memo = __("account_log.{$value}");
        $memo = str_replace('account_log.', '', $memo);
        return $memo;
    }

    /**
     * 写入日志
     *
     * @param int    $user_id
     * @param int    $currency_id
     * @param float  $before
     * @param float  $value
     * @param float  $after
     * @param array  $log_type
     * @param string $memo
     * @param int    $is_lock 是否锁定
     *
     * @return AccountLog|\Illuminate\Database\Eloquent\Model
     */
    public static function insertLog(
        $user_id, $currency_id, $log_type, $before, $value, $after, $extra_data = [], $is_lock = 0
    )
    {
        $memo = $extra_data['memo'] ?? $log_type[1];
        return self::create([
            'user_id' => $user_id,
            'currency_id' => $currency_id,
            'before' => $before,
            'value' => $value,
            'after' => $after,
            'type' => $log_type[0],
            'memo' => $memo,
            'is_lock' => $is_lock,
            'extra_data' => $extra_data,
        ]);
    }

    /**
     * 获取此类的账户类型
     *
     * @return array
     */
    public static function getAccountLogType()
    {
        $reflect = new \ReflectionClass(self::class);
        $type_arr = $reflect->getConstants();
        $arr = [];
        foreach ($type_arr as $v) {
            if (is_array($v)) {
                $arr[] = $v;
            }
        }
        return $arr;
    }
}
