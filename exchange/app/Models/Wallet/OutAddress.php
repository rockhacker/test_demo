<?php


namespace App\Models\Wallet;


use App\Models\Currency\Currency;
use App\Models\Model;
use App\Models\User\User;

class OutAddress extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
