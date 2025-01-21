<?php


namespace App\Models\Currency;

use App\Models\Account\Account;
use App\Models\Account\AccountType;
use App\Models\Chain\ChainProtocol;
use App\Models\Chain\ChainWallet;
use App\Models\Micro\MicroNumber;
use App\Models\Model;
use App\Models\Wallet\OutAddress;

/**
 * Class Currency
 *
 *
 * @property bool $micro_account_display
 * @property bool $change_account_display
 * @property bool $lever_account_display
 * @property bool $legal_account_display
 *
 * @package App\Models\Currency
 */
class Currency extends Model
{
    const ON = 1;
    const OFF = 0;

    protected $casts = [
        'accounts_display' => 'array'
    ];

    protected $appends = [
        'micro_account_display',
        'change_account_display',
        'lever_account_display',
        'legal_account_display',
        'option_account_display',
        //'pb_price'
    ];


    /**判断是否交割账户显示
     *
     */
    public function getMicroAccountDisplayAttribute()
    {
        $displays = $this->getAttribute('accounts_display') ?? [];
        return in_array(AccountType::MICRO_ACCOUNT_ID, $displays);
    }

    /**判断是否币币账户显示
     *
     */
    public function getChangeAccountDisplayAttribute()
    {
        $displays = $this->getAttribute('accounts_display') ?? [];
        return in_array(AccountType::CHANGE_ACCOUNT_ID, $displays);
    }

    /**判断是否合约账户显示
     *
     */
    public function getLeverAccountDisplayAttribute()
    {
        $displays = $this->getAttribute('accounts_display') ?? [];
        return in_array(AccountType::LEVER_ACCOUNT_ID, $displays);
    }

    /**判断是否法币账户显示
     *
     */
    public function getLegalAccountDisplayAttribute()
    {
        $displays = $this->getAttribute('accounts_display') ?? [];
        return in_array(AccountType::LEGAL_ACCOUNT_ID, $displays);
    }


    /**判断是否期权账户显示
     *
     */
    public function getOptionAccountDisplayAttribute()
    {
        $displays = $this->getAttribute('accounts_display') ?? [];
        return in_array(AccountType::OPTION_ACCOUNT_ID, $displays);
    }

    public function matches()
    {
        return $this->hasMany(CurrencyMatch::class, 'quote_currency_id');
    }
    public function optionMatches()
    {
        return $this->hasMany(CurrencyMatch::class, 'quote_currency_id')->where("open_option",1);
    }

    public function wallets()
    {
        return $this->hasMany(ChainWallet::class);
    }

    public function outAddresses()
    {
        return $this->hasMany(OutAddress::class);
    }

    public function currencyProtocols()
    {
        return $this->hasMany(CurrencyProtocol::class);
    }

    public function microNumbers()
    {
        return $this->hasMany(MicroNumber::class, 'currency_id', 'id');
    }

    public function getAccountTypesAttribute()
    {
        $accounts_display = $this->accounts_display ?? [];
        return AccountType::whereIn('id', $accounts_display)->where('is_display', AccountType::STATUS_ON)->get();
    }

    public function getIsRechargeAccountAttribute()
    {
        return $this->account_types->where('is_recharge', 1)->count() > 0;
    }

     //获取平台币的价格
     public function getPbPriceAttribute()
     {
         $base_currency_id = $this->getAttribute('id') ?? 0;
         $pb_currency = Currency::where('is_pb',1)->first();
         $pb_currency_id=$pb_currency->id;
         $usdt = Currency::where('code', 'USDT')->first();
         if ($base_currency_id == $pb_currency_id) {
             return 1;
         }else if ($base_currency_id == $usdt->id) {
             $pb_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $pb_currency_id)->first();
             if ($pb_match) {
                 $pb_quo = CurrencyQuotation::where('currency_match_id', $pb_match->id)->first();
                 $pb_price = $pb_quo->close ?? 0;

             } else {
                 $pb_price = $pb_currency->usd_price;
             }

             $base_price =1;

         } else {
             $pb_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $pb_currency_id)->first();
             $base_match = CurrencyMatch::where('quote_currency_id', $usdt->id)->where('base_currency_id', $base_currency_id)->first();
             if (!$pb_match || !$base_match) {
                 $pb_price = $pb_currency->usd_price;
                 $base_price = $this->getAttribute('usd_price')??0;
             } else {
                 $pb_quo = CurrencyQuotation::where('currency_match_id', $pb_match->id)->first();
                 $base_quo = CurrencyQuotation::where('currency_match_id', $base_match->id)->first();
                 $pb_price = $pb_quo->close ?? 0;
                 $base_price = $base_quo->close ?? 0;
             }

         }

         if ($pb_price == 0 || $base_price == 0) {
             return 0;
         }

         $price=bc($base_price, '/', $pb_price);
         return $price;
     }
}
