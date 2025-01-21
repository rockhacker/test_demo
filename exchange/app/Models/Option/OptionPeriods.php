<?php

namespace App\Models\Option;


use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionPeriods extends Model
{

    const PeriodsNotRun = 0;
    const PeriodsRunning = 1;
    const PeriodsSettlement = 2;
    const PeriodsFinish = 3;

    /**
     * @return BelongsTo
     */
    public function currencyMatch(): BelongsTo
    {
        return $this->belongsTo(CurrencyMatch::class, 'currency_match_id');
    }

    public function second(): BelongsTo
    {
        return $this->belongsTo(OptionSecond::class, 'seconds_id');
    }
}
