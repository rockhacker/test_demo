<?php
/*
 * @Descripttion:
 * @version:
 * @Author: sueRimn
 * @Date: 2020-03-18 14:05:27
 * @LastEditors: sueRimn
 * @LastEditTime: 2020-06-04 16:32:08
 */

namespace App\Models\Project;

use App\Models\Model;
use App\Models\User\User;

class SubProject extends Model
{

    protected $appends = [
        'user_email',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->withDefault([]);
    }

    public function getUserEmailAttribute()
    {
        return $this->user->email;
    }
}
