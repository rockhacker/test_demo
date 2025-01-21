<?php


namespace App\Models\Fund;

use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplyRefund extends Model
{

    protected $table = "apply_refund";
    protected $appends = [
        "user_email",
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

    /**
     * @return BelongsTo
     */
    public function getSubFund(): BelongsTo
    {
        return $this->belongsTo(SubFund::class,"sub_id");
    }
}
