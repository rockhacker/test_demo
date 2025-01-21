<?php


namespace App\Http\Controllers\Admin;


use App\Exceptions\ThrowException;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\ChangeAccount;
use App\Models\Account\MicroAccount;
use App\Models\Account\MicroAccountLog;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\Currency\CurrencyRate;
use App\Models\Follow\Follow;
use App\Models\Fund\Funds;
use App\Models\QuickCharge\QuickCharge;
use App\Models\QuickCharge\QuickChargeOrder;
use App\Models\QuickCharge\QuickSymbol;
use App\Models\QuickCharge\RechargeOrder;
use App\Models\QuickCharge\WireSet;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class QuickChargeController extends Controller
{
    public function list(request $request)
    {
        if($request->method() == "POST"){

            $limit = $request->input('limit', 10);

            /** @var LengthAwarePaginator $res */
            $res = QuickCharge::with('currency')
                ->with(['currencyProtocol'=>function($query){

                    $query->with('chainProtocol');
                }])
                ->orderBy('id', 'desc')
                ->paginate($limit);

            return $this->layuiPageData($res);

        }else{

            return view("admin.quickCharge.list");
        }

    }

    public function add(request $request)
    {
        if(request()->method() == "POST"){
            try{

                $data = request()->all();

                $protocol = CurrencyProtocol::where('id', $data['currency_protoc_id'])->first();
                if (!$protocol) {

                    throw new ThrowException('协议不存在');
                }

                if(empty($data['address'])){

                    throw new ThrowException('地址必须填写');
                }

                $checkForDuplication = QuickCharge::where("currency_protoc_id",$data['currency_protoc_id'])->exists();

                if ($checkForDuplication) {

                    throw new ThrowException('无法重复添加');
                }
                $data['currency_id'] = $protocol->currency_id;
                QuickCharge::create($data);

                return $this->success("添加成功");

            }catch(ThrowException $exception){

                return $this->error($exception->getMessage());
            }

        }else{

            $currencies = CurrencyProtocol::with(['currency','chainProtocol'])->get();
            return view("admin.quickCharge.add",compact('currencies'));
        }

    }


    public function del()
    {

        $id = request()->get("id",0);

        QuickCharge::destroy($id);

        return $this->success('删除成功');
    }


    public function charge_list(request $request)
    {

        if($request->method() == "POST"){

            $limit = $request->input('limit', 10);
            $status = $request->input("status", -1);
            $uid = $request->input('uid', "");
            $email = $request->input('email', "");
            /** @var LengthAwarePaginator $res */
            $res = QuickChargeOrder::with(['currency',"getUsers",'getWire'=>function($query){

                $query->with("getSymbol");
            }])
                ->when($uid, function ($query, $uid) {
                    $query->whereHas('getUsers', function ($query) use ($uid) {
                        $query->where('uid', $uid);

                    });
                })
                ->when($email, function ($query, $email) {
                    $query->whereHas('getUsers', function ($query) use ($email) {
                        $query->where('email', $email);

                    });
                })
                ->when($status != -1 , function($query) use($status) {

                    $query->where("status",$status);
                })
                ->orderBy('id', 'desc')
                ->paginate($limit);

            return $this->layuiPageData($res);

        }else{

            return view("admin.quickCharge.charge_list");
        }

    }

    public function recharge_coin(request $request)
    {
//        $id = $request->input('id', 0);
//
//        $order = QuickChargeOrder::find($id);
//
//        if (!$order){
//
//            return $this->error("找不到订单");
//        }
//
//        if($order->status != 0){
//
//            return $this->error("该订单已上分，无法重复上分");
//        }
//
//        $user = User::find($order->uid);
//        if (!$user){
//
//            return $this->error("找不到该用户");
//
//        }
//        try {
//
//            ChangeAccount::getAccountForLock($order->currency_id,$user->id)
//                ->changeBalance(AccountLog::BLOCK_CHAIN_ADD,$order->number);
//
//            $order->status = 1;
//            $order->save();
//
//            return $this->success("上分成功");
//        }catch(\Exception $exception) {
//
//            return $this->success("上分失败");
//        }
        $id = $request->input('id', 0);
        $type = $request->input('type', 1);

        $order = QuickChargeOrder::find($id);

        if (!$order){

            return $this->error("找不到订单");
        }

        if($order->status != 0){

            return $this->error("该订单已处理过了");
        }

        $user = User::find($order->uid);
        if (!$user){

            return $this->error("找不到该用户");

        }
        try {
//

            if($type == 1){

                ChangeAccount::getAccountForLock($order->currency_id,$user->id)
                    ->changeBalance(AccountLog::BLOCK_CHAIN_ADD,$order->number);

                $order->status = 1;
            }else{

                $order->status = 3;
            }
            $order->save();

            return $this->success("已处理");
        }catch(\Exception $exception) {

            return $this->success("修改状态失败，请重试");
        }
    }

    public function recharge_reject(request $request)
    {
        $id = $request->input('id', 0);

        $order = QuickChargeOrder::find($id);

        if (!$order){

            return $this->error("找不到订单");
        }

        if($order->status != 0){

            return $this->error("该订单已进行操作，请刷新页面");
        }

        try {

            $order->status = 2;
            $order->save();

            return $this->success("操作成功");
        }catch(\Exception $exception) {

            return $this->success("操作失败");
        }


    }




    public function wire_set()
    {

        $symbols = QuickSymbol::get();
        return view("admin.quickCharge.wire_set", ['symbols' => $symbols]);
    }


    public function wire_edit()
    {

        $setting = WireSet::find(request("id",0));
        $symbols = QuickSymbol::get();
        return view("admin.quickCharge.wire_edit", [
            'setting' => $setting,
            "symbols"=>$symbols
        ]);
    }


    public function wire_index()
    {

        return view("admin.quickCharge.wire_index");
    }


    public function wire_index_post(Request $request)
    {
        $limit = $request->input('limit', 10);

        $res = WireSet::orderBy('id', 'desc')
            ->paginate($limit);

        foreach($res as $k => $v){

            $v->bank_coin = QuickSymbol::where("id",$v->bank_coin)->value("name");
        }

        return $this->layuiPageData($res);
    }



    public function bank_save()
    {

        $data = request()->all();
        if(empty($data['bank_coin'])){

            return $this->error("币种必须选择");
        }

//        if(WireSet::where("bank_coin",$data['bank_coin'])->exists()){
//
//            return $this->error("该货币已被添加");
//        }

        WireSet::Create($data);

        return $this->success("添加成功");

    }



    public function wire_delete()
    {

        WireSet::destroy(\request("id",0));
        return $this->success("删除成功");
    }



    public function bank_update()
    {
        $data = request()->all();

        if(empty($data['bank_coin'])){

            return $this->error("币种必须选择");
        }

//        if(WireSet::where("bank_coin",$data['bank_coin'])->where("id","!=",$data["id"])->exists()){
//
//            return $this->error("该货币已被添加");
//        }

        WireSet::where("id",$data['id'])->update($data);

        return $this->success("修改成功");

    }




    public function symbol_set_index()
    {

        return view("admin.quickCharge.symbol_set_index");
    }




    public function symbol_set_post(Request $request)
    {
        $limit = $request->input('limit', 10);

        $res = QuickSymbol::orderBy('id', 'desc')
            ->paginate($limit);

        return $this->layuiPageData($res);

    }



    public function symbol_set_delete(Request $request)
    {
        $id = $request->input('id', 0);

        QuickSymbol::destroy($id);

        return $this->success("删除成功");
    }



    public function symbol_set_add()
    {

        return view("admin.quickCharge.symbol_set_add");
    }



    public function symbol_set_save(Request $request)
    {
        $name = $request->input('name', "");

        if(!$name){

            return $this->error("币种名称必须填写");
        }

        if(QuickSymbol::where("name",$name)->exists()){

            return $this->error("该币种已存在");
        }

        QuickSymbol::create([
            "name"=>$name
        ]);

        return $this->success("创建成功");
    }



    public function symbol_set_edit(Request $request)
    {
        $id = $request->input('id', 0);

        return view("admin.quickCharge.symbol_set_edit",["info"=>QuickSymbol::find($id)]);
    }



    public function symbol_set_update(Request $request)
    {

        $id = $request->input('id', 0);
        $name = $request->input('name', 0);

        if(!$name){

            return $this->error("币种名称必须填写");
        }

        if(QuickSymbol::where("name",$name)->where("id","!=",$id)->exists()){

            return $this->error("该币种已存在");
        }

        QuickSymbol::where("id",$id)->update([
            "name"=>$name
        ]);
        return $this->success("修改成功");
    }




    public function recharge_order_list(request $request)
    {

        if($request->method() == "POST"){

            $limit = $request->input('limit', 10);
            $status = $request->input("status", -1);
            $uid = $request->input('uid', "");
            $email = $request->input('email', "");
            /** @var LengthAwarePaginator $res */
            $res = RechargeOrder::with(['getRate',"getUsers"])->when($uid, function ($query, $uid) {
                $query->whereHas('getUsers', function ($query) use ($uid) {
                    $query->where('uid', $uid);

                });
            })
                ->when($email, function ($query, $email) {
                    $query->whereHas('getUsers', function ($query) use ($email) {
                        $query->where('email', $email);

                    });
                })
                ->when($status != -1 , function($query) use($status) {

                    $query->where("status",$status);
                })
                ->orderBy('id', 'desc')
                ->paginate($limit);
            return $this->layuiPageData($res);

        }else{

            return view("admin.quickCharge.recharge_order_list");
        }

    }



    public function recharge_order_coin(request $request)
    {
        $id = $request->input('id', 0);

        $order = RechargeOrder::find($id);

        if (!$order){

            return $this->error("找不到订单");
        }

        if($order->style != 1){

            return $this->error("该订单已上分，无法重复上分");
        }

        $user = User::find($order->user_id);
        if (!$user){

            return $this->error("找不到该用户");

        }
        try {

            //拿到该币种
            $currency_rate = CurrencyRate::where('id',$order->currency_rate_id)->first();

            //根据汇率换算该币种
            $number = round($order['exch_usdt_num'] , 6);

            MicroAccount::getAccountForLock($currency_rate['currency_id'],$user->id)
                ->MicroChangeBalance(MicroAccountLog::BANK_CHAIN_ADD,$number);

            $order->style = 2;
            $order->updated_at = date("Y-m-d H:i:s");
            $order->save();

            return $this->success("上分成功");
        }catch(\Exception $exception) {

            return $this->success("上分失败");
        }

    }



    public function recharge_order_reject(request $request)
    {
        $id = $request->input('id', 0);

        $order = RechargeOrder::find($id);

        if (!$order){

            return $this->error("找不到订单");
        }

        if($order->style != 1){

            return $this->error("该订单已进行操作，请刷新页面");
        }

        try {

            $order->style = 3;
            $order->updated_at = date("Y-m-d H:i:s");
            $order->save();

            return $this->success("操作成功");
        }catch(\Exception $exception) {

            return $this->success("操作失败");
        }


    }

}
