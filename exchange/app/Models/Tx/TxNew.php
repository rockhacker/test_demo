<?php


namespace App\Models\Tx;

use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\ChangeAccount;
use App\Models\Currency\CurrencyMatch;
use App\Models\User\User;
use App\Models\Model;

use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ThrowException;
use App\Models\Currency\Currency;

class TxNew extends Model
{
    protected $table = 'tx_new';
    protected $appends = [
        'base_currency_code',
        'quote_currency_code',
    ];

    public function quoteCurrency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function getBaseCurrencyCodeAttribute()
    {
        return $this->baseCurrency->code ?? __('model.未知');
    }

    public function getQuoteCurrencyCodeAttribute()
    {
        return $this->quoteCurrency->code ?? __('model.未知');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'uid' => __('model.未知')
        ]);
    }

    public function currencyMatch()
    {
        return $this->belongsTo(CurrencyMatch::class);
    }



}
