<?php


namespace App\Http\Controllers\Api;


use App\Logic\UDunClound;
use App\Models\Account\Account;
use App\Models\Account\AccountDraw;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Activity\RegActivity;
use App\Models\Activity\RegActivityLists;
use App\Models\Agent\Agent;
use App\Models\Chain\ChainProtocol;
use App\Models\Chain\ChainWallet;
use App\Models\Chain\TxHash;
use App\Models\Commission\CommissionLists;
use App\Models\Commission\SetCommission;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\User\User;
use App\Models\Wallet\UdCallback;
use DB;
use Log;

class NoticeController extends Controller
{
    public $ETHDecimals = 18;

    public function UDunNotice(){
        $res = UDunClound::callBack();
        if ($res['code']) {

            $data = $res['data'];

            $decimals = 6;

            switch ($data['mainCoinType']) {
                case "60":

                    $decimals = $this->ETHDecimals;
                    break;

            }

            $has = UdCallback::where("tradeId", $data['tradeId'])->where("tradeType", $data['tradeType'])->first();

            $amount = $data['amount'] / pow(10, $data['decimals']);

            if (!$has) {
                DB::beginTransaction();
                try {

                    switch ($data['tradeType']) {
                        //充币回调
                        case 1:
                            if($data['status'] == 3){

                                // $currency = Currency::where('main_coin_type',$data['mainCoinType'])->where('coin_type',$data['coinType'])->first();

                                // $wallet = ChainWallet::where('address',$data['address'])->firstOrFail();
                                // // 只有币币账户有充币
                                // $uid = $wallet->user_id;
                                // $account = Account::getAccountByType(1, $currency->id, $wallet->user_id);
                                // $wallet->increment($amount);
                                // $account->changeBalance(AccountLog::BLOCK_CHAIN_ADD, $amount);
                                // $type = TxHash::RECHARGE;
                                // $tx = TxHash::insertHash($wallet->user_id, $currency->id, $type, $data['txid'], $wallet->currency_protocol_id,$amount);


//                                $txCurrencyId = Currency::where('main_coin_type',$data['mainCoinType'])->where('coin_type',$data['coinType'])->value("id");

                                $pid = ChainProtocol::where('main_coin_type',$data['mainCoinType'])->where('coin_type',$data['coinType'])->value("id");

                                $txCurrencyIdArr = CurrencyProtocol::where("chain_protocol_id",$pid)->select("currency_id")->get();

                                $chainWallet = ChainWallet::where('address', $data['address'])->first();
                                foreach($txCurrencyIdArr as $key =>$txVal){

                                    $txCurrencyId = $txVal->currency_id;

                                    if($txCurrencyId == $chainWallet->currency_id){
                                        //根据地址查询出链上钱包
                                        $uid = $chainWallet->user_id;
                                        Log::channel('wallet_recharge')->alert("充值金额:{$data['address']},{$amount}", $data);

                                        $account_type_id = AccountType::where('is_recharge', AccountType::IS_RECHARGE)->first();

                                        $tx = TxHash::insertHash($uid, $chainWallet->currency_id, TxHash::RECHARGE, $data['txId'], $chainWallet->currency_protocol_id,$amount , TxHash::STATUS_SUCCESS);

                                        if (!$account_type_id) {
                                            Log::channel('wallet_recharge')->error("找不到账户", $data);
                                            // throw new ThrowException("找不到充币账户");
                                            return "err";
                                        }

                                        $currency = Currency::where("id",$chainWallet->currency_id)->firstOrFail();
                                        //  如果是平台代币需要转换对应汇率
                                        if($currency->is_db){
                                            if(!$currency->usd_price)throw new \Exception("平台代币：" . $currency->code . "未设置USDT价格，请联系管理员手动上分。交易哈希为：" . $data['txid']);
                                            $amount = bcdiv($amount,$currency->usd_price,8);
                                        }

                                        $account = Account::getAccountByType($account_type_id->id, $chainWallet->currency_id, $chainWallet->user_id);

                                        $account->changeBalance(AccountLog::BLOCK_CHAIN_ADD, $amount);

                                        //活动-反金
                                        $act = RegActivity::find(1);

                                        if(!empty($act->id) && $act->is_open == 1 && $act->give_number >= 0){

                                            //检查是否是第一次入金
                                            if(!RegActivityLists::where("user_id",$chainWallet->user_id)->exists()){

                                                $account = Account::getAccountByType($account_type_id->id, $act->currency_id, $chainWallet->user_id);

                                                $account->changeBalance(AccountLog::ACTIVITY_REG_FIRST, $act->give_number);

                                                $act_list = new RegActivityLists();
                                                $act_list->user_id = $chainWallet->user_id;
                                                $act_list->amount = $act->give_number;
                                                $act_list->currency_id = $act->currency_id;
                                                $act_list->save();
                                            }

                                        }

                                        //记录反佣列表
                                        $parent_id = User::where("id",$uid)->value("parent_id") ?? 0;

                                        if($parent_id > 0){

                                            $commission_setting = SetCommission::find(1);

                                            //查找是否是代理
                                            if(Agent::where("user_id",$parent_id)->exists()){

                                                if($commission_setting->agent_rate > 0){

                                                    CommissionLists::create([
                                                        "from_user_id"=>$uid,
                                                        "to_user_id"=>$parent_id,
                                                        "order_amount"=>$amount,
                                                        "currency_id"=>$chainWallet->currency_id,
                                                        "status"=>1,
                                                        "exc_amount"=>round($amount*$commission_setting->agent_rate,6)
                                                    ]);
                                                }

                                            }else{

                                                if($commission_setting->customer_rate > 0){

                                                    CommissionLists::create([
                                                        "from_user_id"=>$uid,
                                                        "to_user_id"=>$parent_id,
                                                        "order_amount"=>$amount,
                                                        "currency_id"=>$chainWallet->currency_id,
                                                        "status"=>1,
                                                        "exc_amount"=>round($amount*$commission_setting->customer_rate,6)
                                                    ]);
                                                }

                                            }
                                        }
                                    }
                                }


                            }

                            break;

                        //提币回调
                        case 2:
                            $uid    = 0;
                            $detail = AccountDraw::where("businessId", $data['businessId'])->first();

                            if ($detail) {

                                $uid = $detail->user_id;
                                $account = Account::getAccountByType($detail->account_type_id, $detail->currency_id, $detail->user_id);
                                if(in_array($data['status'],[2,3,4])){ // 0待审核 1审核成功 2审核驳回 3交易成功 4交易失败
                                    $account->changeLockBalance(AccountLog::WITHDRAW_CONFIRM, -$detail->number); //交易完成扣除锁定余额
                                }
                                if($data['status'] == 3){

                                    $detail->status = 4; // AccountDraw::STATUS_SUCCESS
                                    $type = TxHash::WITHDRAW;
                                    $tx = TxHash::insertHash($detail->user_id, $detail->currency_id, $type, $data['txId'], $detail->currency_protocol_id,$detail->number);
                                    //写入哈希
                                    $detail->tx_hash_id = $tx->id;

                                } else if(in_array($data['status'],[2,4])){

                                    $account->changeBalance(AccountLog::WITHDRAW, $detail->number);
                                    $detail->status = 3; //汇出失败 AccountDraw::STATUS_FIELD

                                }

                                $detail->finish_time = date("Y-m-d H:i:s");
                                $detail->save();
                            }

                            break;

                        default:

                            return "error";
                            break;
                    }


                    $id = UdCallback::insertGetId([
                        "address"      => $data['address'],
                        "amount"       => $amount,
                        "decimals"     => $data['decimals'],
                        "fee"          => $data['fee'] / pow(10, $decimals),
                        "coinType"     => $data['coinType'],
                        "mainCoinType" => $data['mainCoinType'],
                        "businessId"   => empty($data['businessId']) ? '' : $data['businessId'],
                        "blockHigh"    => $data['blockHigh'],
                        "status"       => $data['status'],
                        "tradeId"      => $data['tradeId'],
                        "tradeType"    => $data['tradeType'],
                        "txid"         => empty($data['txId']) ? '' : $data['txId'],
                        "memo"         => $data['memo'],
                        "created_at"   => date("Y-m-d H:i:s"),
                        "user_id"      => $uid
                    ]);

                    //交易成功并且是充值回调
//                    if ($data['tradeType'] == 1 && $data['status'] == 3) {
//
//                        (new CommissionController)->runCommission($data['coinType'], $data['mainCoinType'], $mid, $amount, $id);
//                    }

                    DB::commit();
                    return "success";

                } catch (\Exception $exception) {
                    var_dump($exception->getMessage(),$exception->getLine(),$exception);
                    DB::rollBack();
                }
            } else {

                try {
                    DB::beginTransaction();
                    switch ($data['tradeType']) {

                        //提币回调
                        case 2:

                            $detail = AccountDraw::where("businessId", $data['businessId'])->first();

                            if ($detail) {

                                $account = Account::getAccountByType($detail->account_type_id, $detail->currency_id, $detail->user_id);
                                if(in_array($data['status'],[2,3,4])){ // 0待审核 1审核成功 2审核驳回 3交易成功 4交易失败
                                    $account->changeLockBalance(AccountLog::WITHDRAW_CONFIRM, -$detail->number); //交易完成扣除锁定余额
                                }
                                if($data['status'] == 3){

                                    $detail->status = 4; // AccountDraw::STATUS_SUCCESS
                                    $type = TxHash::STATUS_SUCCESS;
                                    $tx = TxHash::insertHash($detail->user_id, $detail->currency_id, $type, $data['txId'], $detail->currency_protocol_id,$detail->number);
                                    //写入哈希
                                    $detail->tx_hash_id = $tx->id;

                                } else if(in_array($data['status'],[2,4])){

                                    $account->changeBalance(AccountLog::WITHDRAW, $detail->number);
                                    $detail->status = 3; //汇出失败 AccountDraw::STATUS_FIELD

                                }

                                $detail->finish_time = date("Y-m-d H:i:s");
                                $detail->save();
                            }

                            UdCallback::where("tradeId", $data['tradeId'])->update([
                                "address"      => $data['address'],
                                "amount"       => $amount,
                                "decimals"     => $data['decimals'],
                                "fee"          => $data['fee'] / pow(10, $decimals),
                                "coinType"     => $data['coinType'],
                                "mainCoinType" => $data['mainCoinType'],
                                "businessId"   => empty($data['businessId']) ? '' : $data['businessId'],
                                "blockHigh"    => $data['blockHigh'],
                                "status"       => $data['status'],
                                "tradeType"    => $data['tradeType'],
                                "txid"         => empty($data['txId']) ? '' : $data['txId'],
                                "memo"         => $data['memo'],
                            ]);

                            break;

                        default:

                            return "error";
                            break;
                    }

                    DB::commit();
                    return "success";
                } catch (\Exception  $exception) {
                    DB::rollBack();
                }

            }


            return "error-插入记录失败";
        }

        return "error-校验签名失败";
    }
}
