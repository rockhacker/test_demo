<?php


namespace App\Models\Account;


use App\Models\Forex\ForexSettleCurrency;

class ForexAccount extends Account
{

    public $logClass = ForexAccountLog::class;

    public function currency()
    {
        return $this->belongsTo(ForexSettleCurrency::class,'currency_id');
    }

    public function getCurrencyCodeAttribute()
    {
        return $this->currency->currency_name ?? __('model.未知');
    }
}
