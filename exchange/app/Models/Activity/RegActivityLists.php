<?php


namespace App\Models\Activity;

use App\Models\Currency\Currency;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegActivityLists extends User
{
    protected $table = "reg_activity_lists";

    public function getUserInfo(): BelongsTo
    {

        return $this->belongsTo(User::class,"user_id");

    }

    public function currency (): BelongsTo
    {


        return $this->belongsTo(Currency::class,"currency_id");
    }

}
