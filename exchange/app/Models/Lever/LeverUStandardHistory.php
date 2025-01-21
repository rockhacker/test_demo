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

class LeverUStandardHistory extends Model
{
    protected $table = 'Lever_u_standard_history';


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
        if ($status == LeverUStandard::STATUS_ENTRUST || $status == LeverUStandard::STATUS_CANCEL) {
            return 0.00;
        }
        $multiple = $this->getAttribute('multiple');
        $caution_money = $this->getAttribute('caution_money');
//        $multiple_number = bc_mul($number, $multiple);
        $update_price = $this->getAttribute('update_price');
        $price = $this->getAttribute('price');


        /**
         * U本位盈亏计算
         * 做多：
         *（合约当前价- 合约开仓价）/ 开仓价 x 杠杠 x 保证金
         * 做空：
         *（合约开仓价- 合约当前价）/ 开仓价 x 杠杠 x 保证金
         *
         */
        $diff = $type == LeverUStandard::WAY_BUY ? bc(bc($update_price, '-', $price),'/',$price) : bc(bc($price, '-', $update_price),'/',$price);
        $profits = bc(bc($diff, '*', $multiple),'*',$caution_money);
        return $profits;
    }
    /**
     * 平仓订单入库
     * @param $lever_transaction
     * @return mixed
     * @throws \Exception
     */
    public static function closed($lever_transaction)
    {
        $lever_history = self::unguarded(function () use ($lever_transaction){
            $lever_data = DB::table('lever_u_standard')->find($lever_transaction->id);
            $create = [];
            foreach ($lever_data as $key => $item) {
                if($key == 'id'){
                   continue;
                }
                $create[$key] = $item;
            }
            $create['position_id'] = $lever_transaction->id;
            return self::create($create);
        });
        LeverUStandard::find($lever_transaction->id)->delete();
        return $lever_history;
    }
}
