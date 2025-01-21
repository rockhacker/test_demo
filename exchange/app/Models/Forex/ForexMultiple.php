<?php


namespace App\Models\Forex;


use App\Models\Model;

class ForexMultiple extends Model
{
    public function TradeList()
    {
        return $this->belongsTo(ForexTradeList::class, 'forex_id');
    }
}
