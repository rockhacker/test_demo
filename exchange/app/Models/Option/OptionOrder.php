<?php


namespace App\Models\Option;


use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OptionOrder extends Model
{

    const STATUS_OPENED = 1; //交易中
    const STATUS_CLOSING = 2; //平仓中
    const STATUS_CLOSED = 3; //已平仓



    public function currencyMatch(): BelongsTo
    {
        return $this->belongsTo(CurrencyMatch::class, 'match_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(OptionPeriods::class, 'period_id');
    }
    public function getUser(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }
}
