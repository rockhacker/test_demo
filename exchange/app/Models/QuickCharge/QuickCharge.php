<?php

namespace App\Models\QuickCharge;

use App\Models\Chain\ChainProtocol;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickCharge extends Model
{

    protected $appends = [
        "currency_code",
        'protocol_code',
    ];

    public function getCurrencyCodeProtocolAttribute()
    {
        return $this->currency->code.'-'.$this->protocol_code ?? __('model.未知');
    }
    public function getUidAttribute()
    {
        return $this->user->uid ?? __('model.未知');
    }

    public function getChainProtocolCodeAttribute()
    {
        return $this->chainProtocol->code ?? __('model.未知');
    }
    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code ?? __('model.未知');
    }

    public function getProtocolCodeAttribute()
    {
        return $this->currencyProtocol->chainProtocol->code ?? __('model.未知');
    }
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function currencyProtocol(): BelongsTo
    {
        return $this->belongsTo(CurrencyProtocol::class,"currency_protoc_id");
    }
}
