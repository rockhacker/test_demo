<?php


namespace App\Models\Fund;

use App\Exceptions\ThrowException;
use App\Models\Model;
use App\Models\Currency\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Funds extends Model
{

    const SUBSCRIPTING = 1;//认购中
    const TOBESubscribed = 2;//认购中
    const LtSOver = 4;//已结束

    protected $appends = [
        "currency_code",
        "status_str"
    ];

    public function getStatusStrAttribute()
    {
        $rp = __('model.未知');
        switch($this->status){
            case self::SUBSCRIPTING :

                if(time() > strtotime($this->start_time)){

                    $rp = __('model.认购中');
                }else{

                    $rp = __('model.待认购');
                }

                break;
            case self::TOBESubscribed:
                $time = date("Y-m-d H:i:s");
                $rp = __('model.认购中');
                if ($this->over_time <= $time) {

                    $rp = __('model.运作中');
                }

                break;

            case self::LtSOver:

                $rp = __('model.产品已结束');
                break;
        }

        return $rp;
    }

    public function getCurrencyCodeAttribute()
    {
        return $this->currency->code ?? __('model.未知');
    }

    public function currency (): BelongsTo
    {


        return $this->belongsTo(Currency::class,"currency_id");
    }

    /**
     * @return false|string
     */
    public static function gen_next_time(){

        return date('Y-m-d H:i:s', strtotime ("+1 day"));
    }
}
