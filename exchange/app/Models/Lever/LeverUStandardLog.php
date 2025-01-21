<?php

namespace App\Models\Lever;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Model;
use App\Models\Account\{Account, AccountLog, AccountType};
use App\Models\User\User;
use App\Models\Currency\{CurrencyQuotation, CurrencyMatch};
use App\Models\Setting\Setting;
use App\Events\Lever\LeverClosedEvent;
use App\Jobs\{HandleUserLever, LeverClosed, LeverPushTrade, LeverHandle, SendMarket, LeverClosing};
use App\Logic\{ConnectRattleMq, Market, SocketPusher};

class LeverUStandardLog extends Model
{
    protected $table = 'Lever_u_standard_log';


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
