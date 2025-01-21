<?php


namespace App\Http\Controllers\Admin;


use App\Models\Forex\ForexQuotation;
use App\Models\Forex\ForexTradeList;

class ForexQuotationController extends Controller
{
    public function index()
    {
        return view('admin.forexQuotation.index');
    }

    public function list()
    {
        $limit = request('limit', 10);
        $list = ForexQuotation::whereHas('TradeList')->with('TradeList')
            ->orderBy('id', 'DESC')->paginate($limit);
        return $this->layuiPageData($list);
    }

    public function clearKline()
    {
        $forex_id = request('forex_id');
        ForexQuotation::clearKline($forex_id);
        return $this->success('操作成功');
    }
}
