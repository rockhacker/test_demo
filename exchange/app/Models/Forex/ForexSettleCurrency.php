<?php


namespace App\Models\Forex;


use App\Models\Currency\Currency;
use App\Models\Model;

class ForexSettleCurrency extends Model
{
    public $timestamps = false;

    protected $appends = [
        'recharge_currency_name'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class,'recharge_currency_id');
    }

    public function getRechargeCurrencyNameAttribute()
    {
        return $this->currency->code ?? __('model.未知');
    }
}
