<?php


namespace App\Models\Prizes;


use App\Models\Model;
use App\Models\User\User;

class PrizesOrder  extends Model
{
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prizes()
    {
        return $this->belongsTo(Prizes::class);
    }
}
