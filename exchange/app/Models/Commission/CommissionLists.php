<?php


namespace App\Models\Commission;

use App\Models\Currency\Currency;
use App\Models\Setting\Setting;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use App\Models\Model;

class CommissionLists extends Model
{

    protected $table = 'commission_lists';

    public function toUserInfo(): BelongsTo
    {
        return $this->belongsTo(User::class,"to_user_id");
    }

    public function fromUserInfo(): BelongsTo
    {
        return $this->belongsTo(User::class,"from_user_id");
    }

    public function currency (): BelongsTo
    {
        return $this->belongsTo(Currency::class,"currency_id");
    }
}
