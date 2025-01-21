<?php

namespace App\Models\Option;


use App\Models\Currency\Currency;
use App\Models\Model;

class OptionNumber extends Model
{
    protected $appends = ['currency_code'];

    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code ?? '币种不存在';
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
