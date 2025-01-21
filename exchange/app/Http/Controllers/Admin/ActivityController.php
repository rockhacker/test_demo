<?php

namespace App\Http\Controllers\Admin;

use App\BlockChain\BlockChain;
use App\Exceptions\ThrowException;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Activity\RegActivity;
use App\Models\Activity\RegActivityLists;
use App\Models\Chain\ChainProtocol;
use App\Models\Chain\TxHash;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\Fund\Funds;
use App\Models\User\User;
use App\Models\Account\AccountDraw;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ActivityController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function set()
    {

        $currencies = Currency::all();
        $data = RegActivity::find(1);
        return view('admin.activity.set',['currencies'=>$currencies,'data'=>$data]);
    }

    /**
     * @return JsonResponse
     */
    public function set_save(): JsonResponse
    {
        $is_open = request("is_open",0);
        $currency_id = request("currency_id",0);
        $give_number = request("give_number",0);

        RegActivity::updateOrCreate([
            "id"=>1,
        ],[
            "is_open"=>$is_open,
            "currency_id"=>$currency_id,
            "give_number"=>$give_number,
        ]);


        return $this->success("保存成功");
    }

    public function lists(Request $request)
    {

        $limit = $request->input('limit', 10);

        /** @var LengthAwarePaginator $funds */
        $funds = RegActivityLists::with('getUserInfo')->with('currency')->orderBy('id', 'desc')->paginate($limit);

        return $this->layuiPageData($funds);

    }

    public function list()
    {

        return view('admin.activity.list');
    }

}
