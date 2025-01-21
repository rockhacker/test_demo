<?php


namespace App\Models\Fund;

use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubFund extends Model
{

    protected $table = "sub_fund";

    protected $appends = [
        "user_email"
    ];

    public function getUserEmailAttribute()
    {
        return $this->getUserInfo->email;
    }

    public function getUserInfo(): BelongsTo
    {

        return $this->belongsTo(User::class,"user_id");

    }

    public function getFund(): BelongsTo
    {

        return $this->belongsTo(Funds::class,"fund_id");

    }
}
