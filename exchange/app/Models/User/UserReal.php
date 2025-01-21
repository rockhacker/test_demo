<?php


namespace App\Models\User;

use App\Models\Model;
use App\Models\System\Area;

class UserReal extends Model
{
    const WAIT = 0;
    const REJECT = 1;
    const CONFORM = 2;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
