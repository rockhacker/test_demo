<?php


namespace App\Models\Forex;


use App\Logic\Market;
use App\Models\Model;
use Illuminate\Redis\Connectors\PhpRedisConnector;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;

class ForexQuotation extends Model
{
    public $timestamps = false;

    public function TradeList()
    {
        return $this->belongsTo(ForexTradeList::class, 'forex_id');
    }

    public static function clearKline($forex_id)
    {
        $forex = ForexTradeList::where('id',$forex_id)->first();
        $redisConf = config('database.redis.default');
        $client = new PhpRedisConnector();
        $redis = $client->connect($redisConf,[]);
        foreach (Market::PERIODS as $period){
            $key = "forex:kline:{$forex->code}:{$period}";
            $redis->del($key);
        }
        $redis->close();
    }
}
