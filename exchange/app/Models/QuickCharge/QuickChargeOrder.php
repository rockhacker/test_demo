<?php

namespace App\Models\QuickCharge;

use App\Models\Currency\Currency;
use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickChargeOrder extends Model
{

    protected $appends = [
        "currency_code",
        "email"
    ];

    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code ?? __('model.未知');
    }

    public function getEmailAttribute()
    {
        return $this->getUsers->email ?? __('model.未知');
    }


    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getUsers(): BelongsTo
    {
        return $this->belongsTo(User::class,"uid","id");
    }

    public function getWire(): BelongsTo
    {
        return $this->belongsTo(WireSet::class,"wire_id","id");
    }
}
