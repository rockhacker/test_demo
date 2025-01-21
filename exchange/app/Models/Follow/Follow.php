<?php


namespace App\Models\Follow;

use App\Models\Model;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
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
}
