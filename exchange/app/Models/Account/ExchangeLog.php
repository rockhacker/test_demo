<?php


namespace App\Models\Account;

use App\Http\Controllers\Api\MarketController;
use App\Logic\Market;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Model;
use App\Models\User\User;
use App\Exceptions\ThrowException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeLog extends Model
{

    protected $appends = [
        "base_currency_code",
        "quote_currency_code",
        "email"
    ];

    public function user (): BelongsTo
    {

        return $this->belongsTo(User::class,"user_id");
    }


    public function baseCurrency (): BelongsTo
    {

        return $this->belongsTo(Currency::class,"base_currency_id");
    }

    public function quoteCurrency (): BelongsTo
    {


        return $this->belongsTo(Currency::class,"quote_currency_id");
    }


    public function getBaseCurrencyCodeAttribute()
    {
        return $this->baseCurrency->code;
    }

    public function getQuoteCurrencyCodeAttribute()
    {
        return $this->quoteCurrency->code;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }
}
