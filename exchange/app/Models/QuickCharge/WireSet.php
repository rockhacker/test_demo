<?php

namespace App\Models\QuickCharge;

use App\Models\Currency\Currency;
use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WireSet extends Model
{

    protected $table = "wire_set";

    public function getSymbol(): BelongsTo
    {
        return $this->belongsTo(QuickSymbol::class,"bank_coin","id");
    }

}
