<?php


namespace App\Http\Controllers\Admin;


use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Tx\TxNew;
use App\Models\User\User;

class NewTxController extends Controller
{

    public function inIndex()
    {
        $currencies = Currency::all();
        return view('admin.txNew.in_index', [
            'currencies' => $currencies
        ]);
    }

    public function List()
    {
        $uid = request('uid', '');
        $currency_match_id = request('currency_match_id', 0);
        $quote_currency_id = request('quote_currency_id', 0);
        $email = request('email', '');
        $mobile = request('mobile', '');
        $type = request('type', 0);

        $list = TxNew::with(['user'])
        ->when($email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->when($mobile, function ($query, $mobile) {
            $query->whereHas('user', function ($query) use ($mobile) {
                $query->where('mobile', $mobile);
            });
        })->when($uid, function ($query, $uid) {
            $query->whereHas('user', function ($query) use ($uid) {
                $query->where('uid', $uid);
            });
        })->when($currency_match_id, function ($query, $currency_match_id) {
            $query->where('currency_match_id', $currency_match_id);
        })->when($quote_currency_id, function ($query, $quote_currency_id) {
            $query->where('quote_currency_id', $quote_currency_id);
        })->where('type',$type)->orderBy('id', 'DESC')->paginate();

        return $this->layuiPageData($list);
    }


}
