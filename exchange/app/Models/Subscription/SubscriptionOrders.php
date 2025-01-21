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
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubscriptionOrders extends Model
{
    protected $table = "subscription_orders";

//

    protected $appends = [
        'currency_name'
    ];

    public function getCurrencyNameAttribute()
    {
        if (!array_key_exists('currency', $this->attributes)) {
            return "";
        }else{
            return $this->currency->code;
        }

    }

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class,"id",'currency_id');
    }

    public function payCurrency(): HasOne
    {
        return $this->hasOne(Currency::class,"id",'pay_currency_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class,"id",'sub_id');
    }

    public function getUserInfo(): BelongsTo
    {

        return $this->belongsTo(User::class,"user_id");

    }
}
