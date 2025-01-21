<?php


namespace App\Models\Prizes;


use App\Models\Model;
use App\Models\User\User;

class PrizesWin  extends Model
{
    const WAIT = 0; // 未抽奖
    const USED = 1; // 已中奖


    protected $table = 'prizes_win';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prizes()
    {
        return $this->belongsTo(Prizes::class);
    }

}
