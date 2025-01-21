<?php

namespace App\Console\Commands\Market;

use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Subscription\Subscription;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**更新系统中的币种价值
 * Class UpdateCurrencyPrice
 *
 * @package App\Console\Commands\Market
 */
class UpdateCurrencyPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:updateCurrencyPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新系统中的币种价值';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateUSDPrice();
//        $this->updateCNYPrice();
    }

//    public function updateCnyPrice()
//    {
//        $quote = strtoupper('CNY');
//
//        $res = http('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
//            'start' => '1',
//            'limit' => '10',
//            'convert' => $quote
//        ], 'GET', [
//            'Accepts' => 'application/json',
//            'X-CMC_PRO_API_KEY' => config('app.coin_market_cap_api_key'),
//        ]);
//
//        $data = collect($res['data']);
//        $currencies = Currency::get();
//        $symbols = $currencies->pluck('code')->toArray();
//
//        //过滤之后系统内需要的数据
//        $new_arr = $data->filter(function ($item) use ($symbols, $quote) {
//            return in_array($item['symbol'], $symbols);
//        })->map(function ($item) use ($quote) {
//            return [
//                'code' => $item['symbol'],
//                'price' => round($item['quote'][$quote]['price'], 8),
//            ];
//        })->values();
//
//        foreach ($new_arr as $item) {
//            Currency::where('code', $item['code'])->update([
//                'cny_price' => $item['price']
//            ]);
//        }
//    }

    public function updateUSDPrice()
    {
        $quote = strtoupper('USD');
//
//        $res = http('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
//            'start' => '1',
//            'limit' => '10',
//            'convert' => $quote
//        ], 'GET', [
//            'Accepts' => 'application/json',
//            'X-CMC_PRO_API_KEY' => config('app.coin_market_cap_api_key'),
//        ]);
//
//        $data = collect($res['data']);

//        $symbols = $currencies->pluck('code')->toArray();
        $currencies = Currency::get();
        foreach($currencies as $v){
            $usd_price = 0;

            $usdtId = Currency::where("code","USDT")->where("main_coin_type",60)->value("id");//ERC20

            if($usdtId){

                if($usdtId == $v->id){
                    //如果是usdt则不需要转换
                    $usd_price = 1;
                }else{
                    $sub_price = Subscription::where("status",1)
                            ->where("currency_id",$v->id)
                            ->value("market_price")??0;
                    if($v->is_new == 1 && $sub_price){

                        $usd_price = $sub_price;
                    }
                    $currency_match_id = CurrencyMatch::where("base_currency_id",$v->id)->where("quote_currency_id",$usdtId)->value("id");

                    if($currency_match_id){

                        $currency_match = CurrencyMatch::find($currency_match_id);

                        if($currency_match){

                            $usd_price = $currency_match->getLastPrice();

                        }
                    }
                }

            }

            Currency::where('id', $v->id)->update([
                'usd_price' => $usd_price
            ]);
        }



    }
}
