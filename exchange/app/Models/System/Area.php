<?php


namespace App\Models\System;

use App\Models\Model;

class Area extends Model
{
    protected $appends = ['lang_name','payway_name','trans_name'];
    protected $hidden = ['name_jp','name_kr','name_vn','name_th','name_hk','name_zh'];

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function getPaywayNameAttribute()
    {
        $payways =explode(",",$this->attributes['payways']);
        $collection = Payway::whereIn("id" , $payways)->get();
        $name = "";
        foreach($collection as $pay){
            $name .= "$pay->name, ";
        }
        return trim($name,", ");
    }

    public function getLangNameAttribute()
    {
        return $this->lang->name ?? __('model.未知');
    }

    public function getTransNameAttribute()
    {
        $lang = \App::getLocale();
        $lang_arr = ['zh','hk','jp','kr','vn','th'];
        $name_field = 'name';
        if(in_array($lang,$lang_arr)){
            $name_field = 'name_' . $lang;
        }
        return $this->attributes[$name_field];
    }

}
