<?php
/*
 * @Descripttion:
 * @version:
 * @Author: sueRimn
 * @Date: 2020-03-18 14:05:27
 * @LastEditors: sueRimn
 * @LastEditTime: 2020-06-04 16:32:08
 */

namespace App\Models\Subscription;

use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    protected $table = "subscription";

//

    protected $appends = [
        'currency_name'
    ];

    public function getCurrencyNameAttribute()
    {
        return $this->currency->code;
    }


    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class,"id",'currency_id');
    }
}
