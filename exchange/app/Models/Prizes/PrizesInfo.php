<?php


namespace App\Models\Prizes;


use App\Models\Model;
use App\Models\System\Lang;

class PrizesInfo  extends Model
{
    public $timestamps = false;

    protected $appends = [
        'lang_name',
    ];

    public function getLangNameAttribute()
    {
        return $this->lang()->value('name');
    }

    public function prizes()
    {
        return $this->belongsTo(Prizes::class);
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }
}
