<?php


namespace App\Models\Currency;

use App\Logic\Market;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Model;
use App\Models\Tx\{HuobiSymbol, TxIn, TxOut};

class CurrencyMatch extends Model
{
    //行情来自
    const EXCHANGE = 0;
    const ROBOT = 1;
    const HUOBI = 2;

    //打开关闭
    const ON = 1;
    const OFF = 0;

    protected $appends = [
        'symbol',
        'base_currency_code',
        'quote_currency_code',
        'lower_symbol'
    ];


    public function getMarketFromNameAttribute()
    {
        $value = $this->getAttribute('market_from');
        $name[self::EXCHANGE] = __('model.交易所');
        $name[self::ROBOT] = __('model.机器人');
        $name[self::HUOBI] = __('model.火币');
        return $name[$value] ?? __('model.未知');
    }

    public function getBaseCurrencyCodeAttribute()
    {
        return $this->baseCurrency->code ?? __('model.未知');
    }

    public function getQuoteCurrencyCodeAttribute()
    {
        return $this->quoteCurrency->code ?? __('model.未知');
    }

    public function getSymbolAttribute()
    {
        $base_currency_code = $this->getAttribute('base_currency_code');
        $quote_currency_code = $this->getAttribute('quote_currency_code');
        return "{$base_currency_code}/{$quote_currency_code}";
    }

    public function getLowerSymbolAttribute()
    {
        $base_currency_code = $this->getAttribute('base_currency_code');
        $quote_currency_code = $this->getAttribute('quote_currency_code');
        return strtolower($base_currency_code . $quote_currency_code);
    }

    public static function getHuobiMatchs()
    {
        $currency_match = self::where('market_from', self::HUOBI)->get();
        $huobi_symbols = HuobiSymbol::pluck('symbol')->all();
        //过滤掉不在火币中的交易对
        $currency_match = $currency_match->filter(function ($value, $key) use ($huobi_symbols) {
            return in_array($value->lower_symbol, $huobi_symbols);
        });
        return $currency_match;
    }

    /**
     * 获取一个交易对(优先从缓存中获取减少数据库开销)
     *
     * @param string $base_currency 基础币名称
     * @param string $quote_currency 计价币名称
     * @param bool $refresh 是否制刷新
     * @return \App\Models\Currency\CurrencyMatch|null
     */
    public static function getSymbolMatch($base_currency, $quote_currency, $refresh = false)
    {
        $symbol = "{$base_currency}/{$quote_currency}";
        $cache_key = "cache_match_symbol:{$symbol}";
        if (!$refresh && Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }
        $match = self::whereHas('baseCurrency', function ($query) use ($base_currency) {
            $query->where('code', $base_currency);
        })->whereHas('quoteCurrency', function ($query) use ($quote_currency) {
            $query->where('code', $quote_currency);
        })->first();
        $match && Cache::put($cache_key, $match, Carbon::now()->addMinutes(1)); // 10分钟缓存
        return $match;
    }

    /**
     * 获取一个交易对(优先从缓存中获取减少数据库开销)
     *
     * @param int $id 交易对id
     * @param bool $refresh 是否制刷新
     * @return \App\Models\Currency\CurrencyMatch|null
     */
    public static function findMatch($id, $refresh = false)
    {
        $key = "cache_match_id:{$id}";
        $cache_has = Cache::has($key);
        if ($refresh || !$cache_has) {
            $match = self::find($id);
            Cache::put($key, $match, Carbon::now()->addMinutes(1));
            return $match;
        }
        return Cache::get($key, null);
    }

    public function quoteCurrency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function currencyQuotation()
    {
        return $this->hasOne(CurrencyQuotation::class);
    }

    public function txIn()
    {
        return $this->hasMany(TxIn::class);
    }

    public function txOut()
    {
        return $this->hasMany(TxOut::class);
    }

    /**
     * 取交易对最新价格(优先从行情获取)
     *
     * @return float|integer|string
     * @throws \Exception
     */
    public function getLastPrice()
    {
        // 优先从Cache取最新价格
        $last_price = 0;
        $last = Market::getKline("{$this->symbol}", '1min', 1);

        if (count($last) > 0) {

            $last = $last->first();
            $last_price = $this->convert_scientific_number_to_normal($last->close);
//            if($this->attributes['id'] == 18){
//        var_dump($last_price);exit;
//            }
        } else {
            // 再从行情取最新价格
            $last = CurrencyQuotation::where('currency_match_id', $this->attributes['id'])->first();
            $last && $last_price = $last->close;
        }
        throw_if(bc($last_price, '<=', 0), new \Exception(__("model.获取行情价格异常")));
        return $last_price;
    }

    /**

     * 将科学计数法的数字转换为正常的数字

     * 为了将数字处理完美一些，使用部分正则是可以接受的

     * @author loveyu

     * @param string $number

     * @return string

     */

    public function convert_scientific_number_to_normal($number)

    {

        if(stripos($number, 'e') === false) {

            //判断是否为科学计数法

            return $number;

        }

        if(!preg_match(

            "/^([\\d.]+)[eE]([\\d\\-\\+]+)$/",

            str_replace(array(" ", ","), "", trim($number)), $matches)

        ) {

            //提取科学计数法中有效的数据，无法处理则直接返回

            return $number;

        }

        //对数字前后的0和点进行处理，防止数据干扰，实际上正确的科学计数法没有这个问题

        $data = preg_replace(array("/^[0]+/"), "", rtrim($matches[1], "0."));

        $length = (int)$matches[2];

        if($data[0] == ".") {

            //由于最前面的0可能被替换掉了，这里是小数要将0补齐

            $data = "0{$data}";

        }

        //这里有一种特殊可能，无需处理

        if($length == 0) {

            return $data;

        }

        //记住当前小数点的位置，用于判断左右移动

        $dot_position = strpos($data, ".");

        if($dot_position === false) {

            $dot_position = strlen($data);

        }

        //正式数据处理中，是不需要点号的，最后输出时会添加上去

        $data = str_replace(".", "", $data);

        if($length > 0) {

            //如果科学计数长度大于0

            //获取要添加0的个数，并在数据后面补充

            $repeat_length = $length - (strlen($data) - $dot_position);

            if($repeat_length > 0) {

                $data .= str_repeat('0', $repeat_length);

            }

            //小数点向后移n位

            $dot_position += $length;

            $data = ltrim(substr($data, 0, $dot_position), "0").".".substr($data, $dot_position);

        } elseif($length < 0) {

            //当前是一个负数

            //获取要重复的0的个数

            $repeat_length = abs($length) - $dot_position;

            if($repeat_length > 0) {

                //这里的值可能是小于0的数，由于小数点过长

                $data = str_repeat('0', $repeat_length).$data;

            }

            $dot_position += $length;//此处length为负数，直接操作

            if($dot_position < 1) {

                //补充数据处理，如果当前位置小于0则表示无需处理，直接补小数点即可

                $data = ".{$data}";

            } else {

                $data = substr($data, 0, $dot_position).".".substr($data, $dot_position);

            }

        }

        if($data[0] == ".") {

            //数据补0

            $data = "0{$data}";

        }

        return trim($data, ".");

    }
}
