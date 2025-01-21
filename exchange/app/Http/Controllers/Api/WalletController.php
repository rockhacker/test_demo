<?php


namespace App\Http\Controllers\Api;


use App\BlockChain\BlockChain;
use App\Logic\UDunClound;
use App\Models\Chain\ChainProtocol;
use App\Models\Chain\ChainWallet;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\QuickCharge\QuickCharge;
use App\Models\User\User;
use App\Models\Wallet\OutAddress;
use App\Notify\Notify;

class WalletController extends Controller
{
    public function wallets()
    {
        $wallets = CurrencyProtocol::with(['wallets' => function ($query) {
            $query->where('user_id', User::getUserId());
        }])->get();

        return $this->success(__('api.请求成功'), $wallets);
    }

    public function wallet()
    {
        $currency_id = request('currency_id', 0);

        $currency = Currency::with(['wallets' => function ($query) {
            $query->where('user_id', User::getUserId());
            $query->select(['id','address','memo','currency_id','chain_protocol_id','currency_protocol_id']);
            $query->with(['chainProtocol'=>function($query){
                $query->with('currencyProtocols')->select('id','code','main_coin_type');
            }]);
        }])->select(['id', 'code', 'draw_min', 'draw_max', 'open_recharge'])
            ->findOrFail($currency_id);

//        if(!empty($currency->wallets)){
//
//            foreach($currency->wallets as $key => &$val){
//                if($val->address){
//
//                    //如果没有区块链协议
//                    if(!isset($val->chainProtocol->main_coin_type)){
//
//                        $val->address = '';
//                        continue;
//                    }
//
//                    $check = UDunClound::existAddress($val->chainProtocol->main_coin_type,$val->address);
//
//                    if(!empty($check['code']) && $check['code'] != 200){
//
//                        $val->address = '';
//                        continue;
//                    }
//                }
//            }
//
//        }

        //把地址替换成快捷充值的地址
        foreach($currency->wallets as $k => $v){

            $v->address = QuickCharge::where("currency_id",$v->currency_id)
                ->where("currency_protoc_id",$v->currency_protocol_id)->value("address");
        }
//        $currency_protocols = CurrencyProtocol::with(['wallets' => function ($query) {
//            $query->where('user_id', 1);
//        }, 'currency' => function ($query) {
//            $query->select();
//        }])->where('currency_id', $currency_id)->get();

        return $this->success(__('api.请求成功'), $currency);
    }

    public function GetDrawAddress(){
        $uid = request('user_id');
        $coin_name = request('coin_name');
        $currency_id = request('currency_id');
        $currency_protocol_id = request('currency_protocol_id');

        $outAddress = OutAddress::where('currency_id',$currency_id)->where('user_id',$uid)->where('currency_protocol_id',$currency_protocol_id)->first();
        $data = [];
        if(!empty($outAddress)){
            $data = [
                'fee' => $outAddress->fee,
                'meno' => $outAddress->meno,
                'address' => $outAddress->out_address,
//            '' => $outAddress->,

            ];
        }
//        $data = $outAddress;
        return $this->success(__('api.请求成功'), $data);
    }

    public function BindDrawAddress(){
        $data = json_decode(request('data'),true);
        $sign = request('sign');
        if(!$sign || $sign != md5(request('data') . 'abcd4321'))
        {
            return response()->json(["code"=> 0,'msg' =>__('api.参数异常')],200, [], JSON_UNESCAPED_UNICODE);
        }
        if(!$data) return response()->json(["code"=> 0,'msg' =>__('api.参数异常')],200, [], JSON_UNESCAPED_UNICODE);
        $user = User::find($data['user_id']);
        $to = !empty($user->mobile) ? 'mobile' : 'email';
//        if(!$data['verificationcode'] || !Notify::checkCode($user->$to,Notify::WITHDRAW,$data['verificationcode'])){
//            return response()->json(['code'=>0, 'msg'=>__('api.验证码错误')],200);
//        }
        if(!$data['user_id'] || !$data['address'] || !$data['coin_name']){
            return response()->json(["code"=> 0,'msg' =>__('api.请填写完整')],200, [], JSON_UNESCAPED_UNICODE);
        }
        $currency = Currency::where('id',$data['currency_id'])->first();
        if(!$currency){
            return response()->json(["code"=> 0,'msg' =>__('api.此币种提币暂未开放')],200, [], JSON_UNESCAPED_UNICODE);
        }
        $out_address = OutAddress::where('currency_id',$currency->id)
            ->where('user_id',$data['user_id'])->where('currency_protocol_id',$data['currency_protocol_id'])->first();
        if(!$out_address){
            $out_address = new OutAddress();
            $out_address->user_id = $data['user_id'];
            $out_address->created_at = date('Y-m-d H:i:s');
        }
        $out_address->currency_id = $data['currency_id'];
        $out_address->currency_protocol_id = $data['currency_protocol_id'];
        if(!empty($data['fee']))$out_address->fee =  $data['fee'];
        if(!empty($data['meno']))$out_address->meno =  $data['meno'];
        $out_address->out_address = $data['address'];
        $out_address->currency_id = $currency->id;
        $res = $out_address->save();
        if($res){
            return response()->json(["code"=> 1,'msg' =>__('api.操作成功')],200, [], JSON_UNESCAPED_UNICODE);
        }
        return response()->json(["code"=> 0,'msg' =>__('api.请求失败')],200, [], JSON_UNESCAPED_UNICODE);
    }

    public function SendVerificationcode()
    {
        $user_id = request('user_id');
        $user = User::findOrFail($user_id);
        if(!empty($user->mobile)){
           $class =  Notify::newInstance(Notify::SMS, $user->mobile, $user->area);
        } else {
           $class =  Notify::newInstance(Notify::EMAIL, $user->email, $user->area);
        }
        $class->template(Notify::SCENES[4])
            ->asyncSend()
            ->remember();
//        var_dump(Notify::checkCode($user->mobile,Notify::WITHDRAW,7851));
        return $this->success(__('api.发送验证码成功'));
    }
}
