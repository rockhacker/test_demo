<?php

namespace App\Console\Commands\Market;

use App\Logic\Market;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Tx\Robot;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**更新k线详情
 * Class UpdateCurrencyPrice
 *
 * @package App\Console\Commands\Market
 */
class UpdateKlineDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:updateKlineDetail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新k线详情';

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
        $currencies = CurrencyMatch::get();

        foreach($currencies as $currencyMatch){

            $get_kline_symbol = $currencyMatch->lower_symbol;

            if(Currency::where("is_db",1)->where("id",$currencyMatch->base_currency_id)->exists()){

                $get_kline_symbol = Robot::where("currency_match_id",$currencyMatch->id)->value("virtual_symbol");
                if (!$get_kline_symbol){

                    continue;
                }
            }

            $day_data = Market::getMarketDetail($get_kline_symbol);
            /**@var CurrencyQuotation $quotation * */
            $quotation = CurrencyQuotation::where('currency_match_id', $currencyMatch->id)->firstOrNew([
                'currency_match_id' => $currencyMatch->id
            ]);
//            var_dump($day_data);
            $quotation->replaceLowHigh($day_data);
        }

    }

}
