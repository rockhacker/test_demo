<?php


namespace App\Models\Forex;


use App\Models\Model;
use App\Models\User\User;

class ForexTransaction extends Model
{
    public $timestamps = false;

    protected $appends = [
        'code',
        'currency_name',
        'uid',
        'account',
        'type_name',
        'status_name',
        'closed_type_name'
    ];

    const TYPE_BUY = 1; //买
    const TYPE_SELL = 2; //卖

    const STATUS_ENTRUST = 0; //挂单中
    const STATUS_OPENED = 1; //交易中
    const STATUS_CLOSING = 2; //平仓中
    const STATUS_CLOSED = 3; //已平仓
    const STATUS_CANCEL = 4; //已撤单

    const CLOSED_TYPE_NONE = 0; //未知
    const CLOSED_TYPE_MARKET = 1; //市价
    const CLOSED_TYPE_LIQUIDATION = 2; //爆仓
    const CLOSED_TYPE_TP = 3; //止盈
    const CLOSED_TYPE_SL = 4; //止损
    const CLOSED_TYPE_ADMIN = 5; //后台


    public static $typeList = [
        '',
        self::TYPE_BUY => '买',
        self::TYPE_SELL => '卖',
    ];

    public static $statusList = [
        self::STATUS_ENTRUST => '挂单中',
        self::STATUS_OPENED => '交易中',
        self::STATUS_CLOSING => '平仓中',
        self::STATUS_CLOSED => '已平仓',
        self::STATUS_CANCEL => '已撤单',
    ];

    public static $closedTypeList = [
        self::CLOSED_TYPE_NONE => '未知',
        self::CLOSED_TYPE_MARKET => '市价',
        self::CLOSED_TYPE_LIQUIDATION => '爆仓',
        self::CLOSED_TYPE_TP => '止盈',
        self::CLOSED_TYPE_SL => '止损',
        self::CLOSED_TYPE_ADMIN => '后台',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function settleCurrency()
    {
        return $this->belongsTo(ForexSettleCurrency::class,'settle_currency_id');
    }

    public function TradeList()
    {
        return $this->belongsTo(ForexTradeList::class, 'forex_id');
    }

    public function getCodeAttribute()
    {
        return $this->tradeList->code ?? '';
    }

    public function getCurrencyNameAttribute()
    {
        return $this->settleCurrency->currency_name ?? '';
    }

    public function getTypeNameAttribute()
    {
        $value = $this->attributes['order_type'] ?? 0;
        return self::$typeList[$value] ?? '';
    }

    public function getStatusNameAttribute()
    {
        $value = $this->attributes['status'] ?? 0;
        return self::$statusList[$value] ?? '';
    }

    public function getClosedTypeNameAttribute()
    {
        $value = $this->attributes['closed_type'] ?? 0;
        return self::$closedTypeList[$value] ?? '';
    }

    public function getAccountAttribute()
    {
        return $this->user()->value('uid');
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

    public function getMobileAttribute()
    {
        return $this->user->mobile ?? '';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }

    public function getUidAttribute()
    {
        return $this->user->uid ?? '';
    }
}
