<?php


namespace App\Models\Forex;


use App\Models\Model;
use App\Models\User\User;

class ForexTradeList extends Model
{
    public $timestamps = false;

    const OFF = 0; // 关闭交易
    const ON = 1; // 开启交易

    public static $statusList = [
        '',
        self::OFF => '关闭交易',
        self::ON => '开启交易'
    ];

    protected $appends = [
        'trade_status_name'
    ];

    public function getTradeStatusNameAttribute()
    {
        $value = $this->attributes['trade_status'] ?? '';
        return self::$statusList[$value] ?? '';
    }
}
