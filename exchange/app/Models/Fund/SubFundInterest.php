<?php


namespace App\Models\Fund;

use App\Models\Model;
use App\Models\Currency\Currency;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubFundInterest extends Model
{
    protected $table = "sub_fund_interest";

    public function getUserInfo(): BelongsTo
    {

        return $this->belongsTo(User::class,"user_id");

    }
}
