<?php


namespace App\Models\Forex;


use App\Models\Model;

class ForexQuotationRobot extends Model
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;


    public $timestamps = false;

    public $appends = [
        'status_name',
        'code',
    ];

    public function getStatusNameAttribute(){
        return $this->status ? '启用' : '关闭';
    }

    public function getCodeAttribute()
    {
        return $this->tradeList->code ?? '';
    }

    public function TradeList()
    {
        return $this->belongsTo(ForexTradeList::class, 'forex_id');
    }
}
