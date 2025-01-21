<?php

namespace App\Http\Controllers;


use App\BlockChain\BlockChain;
use App\Entity\Market\Depth;
use App\Entity\Market\DepthTx;
use App\Entity\TxCompleteEntity;
use App\Entity\TxOrder;
use App\Events\Lever\LeverClosedEvent;
use App\Exceptions\ThrowException;
use App\Jobs\LeverClosing;
use App\Jobs\MatchEngine;
use App\Jobs\PushMarket;
use App\Logic\ConnectRattleMq;
use App\Logic\Market;
use App\Logic\UDunClound;
use App\Logic\User as UserLogic;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Agent\Agent;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Currency\CurrencyProtocol;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Lever\LeverTransaction;
use App\Models\Setting\Setting;
use App\Models\System\Area;
use App\Models\Tx\TxComplete;
use App\Models\Tx\TxIn;
use App\Models\Tx\TxOut;
use App\Models\User\User;
use App\Notify\Notify;
use App\Notify\NotifyTemplate;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use PhpAmqpLib\Message\AMQPMessage;

class TestController extends Controller
{


    public function register($account, $password, $area_id,$invite_code)
    {

        if($invite_code){
            $parent_id = User::where('invite_code', $invite_code)->value('id');

            if (!$parent_id) {
                //$parent_id=0;
                throw new ThrowException(__('api.推荐码错误'));
            }
        }else{
            $parent_id=0;
        }

        $u=User::where("email",$account)->first();
        if(!empty($u)){
            throw new ThrowException(__('api.用户已注册'));
        }

        $user = User::create([
            'password' => $password,
            'area_id' => $area_id,
            'invite_code' => User::generateInviteCode(),
            'uid' => User::generateUid(),
            'is_create_address'=>0,
            "email" => $account,
        ]);

        $user->save();javascript:;

        //创建中心化账户
        AccountType::generateUserAllAccount($user);

        $user->parent_id = $parent_id;
        //创建上级路径
        $user->parents_path = UserLogic::getRealParentsPath($user);
        //寻找上级代理商id
        $user->agent_node_id = Agent::getAgentIdByParentId($parent_id);
        //代理商路径
        $user->agent_path = Agent::agentPath($parent_id);
//        BlockChain::generateAllOnlineWallet($user);
        //创建去中心化钱包
//        CreateAddress::dispatch($user);

//        $user->syncUserInfo();
        $user->save();
        return $user;
    }
    public function test()
    {

//        ConnectRattleMq::publish_send(ConnectRattleMq::$quoteOperateConsume,["123"]);

    return 1;

//        echo exec('sudo supervisorctl restart all');
//        $user = $this->register("ryohei----@ezweb.ne.jp","twek23k4Lk1rq","1","0IPSAU");
//        $jump = Setting::getValueByKey('register_jump', '');
//        return $this->success(__('api.注册成功'), [
//            'user' => $user,
//            'jump' => $jump,
//        ]);
//        try{
//            $invite_code = "0IPSAU";
//            if($invite_code){
//                $parent_id = User::where('invite_code', $invite_code)->value('id');
//
//                if (!$parent_id) {
//                    //$parent_id=0;
//                    throw new ThrowException(__('api.推荐码错误'));
//                }
//            }else{
//                $parent_id=0;
//            }
//
//            $user = User::where("email","meinaizi520@gmail.com")->first();
//
//            $user = User::find($user->id);
//
//            $user->parent_id = $parent_id;
//            //创建上级路径
//            $user->parents_path = UserLogic::getRealParentsPath($user);
//            //寻找上级代理商id
//            $user->agent_node_id = Agent::getAgentIdByParentId($parent_id);
//            //代理商路径
//            $user->agent_path = Agent::agentPath($parent_id);
//            $user->save();
//            var_dump($user);
//
//        }catch (\Exception $exception) {
//
//            var_dump($exception);exit;
//        }




//        $to = "ximenqing121@gmail.com";
//        $area_id = 1;
//        $scene = 6;
//
//        $area = Area::find($area_id);
//        if (!$area) {
//            return $this->error(__('api.国家或地区不存在'));
//        }
//        if (empty($area_id) || empty($scene) || empty($to)) {
//            return $this->error(__('api.参数错误'));
//        }
//
//        Notify::newInstance(Notify::MODUYUNEMAIL, $to, $area)
//            ->template(Notify::SCENES[$scene])
//            ->remember()
//            ->asyncSend()
////                ->send()
//        ;
//
//        return $this->success(__('api.发送验证码成功'));




//        $lever_transaction = LeverTransaction::lockForupdate()->find(request()->get("id"));
//        try {
//            DB::beginTransaction();
//            if (empty($lever_transaction)) {
//                throw new \Exception(__('model.交易不存在'));
//            }
////            $last_price = $lever_transaction->currencyMatch->getLastPrice();
//            $last_price = request()->get("price");
//            $lever_transaction->refresh();
//            // if ($lever_transaction->status != self::STATUS_TRANSACTION) {
//            //     throw new \Exception('该笔交易状态异常,不能平仓' . $lever_transaction->status);
//            // }
//            //更新状态
//            $lever_transaction->update_price = $last_price;
//            $lever_transaction->update_time = microtime(true);
//            $lever_transaction->status = LeverTransaction::STATUS_CLOSING;
//            $lever_transaction->handle_time = microtime(true);
//            $result = $lever_transaction->save();
//            if (!$result) {
//                throw new \Exception(__('model.平仓失败:锁定交易状态失败'));
//            }
//
//            $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
//
//            if (empty($legal_wallet)) {
//                throw new \Exception(__('model.钱包不存在'));
//            }
//            $profit = $lever_transaction->profits;
//            $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
//            $pre_result = bc($legal_wallet->balance, '+', $change);
//            $diff = 0;
//
//            $extra_data = [
//                'trade_id' => $lever_transaction->id,
//                'caution_money' => $lever_transaction->caution_money,
//                'profit' => $profit,
//                'diff' => $diff,
//                'mome' => '平仓资金处理',
//                'strict' => false
//            ];
//            $legal_wallet->changeBalance(AccountLog::LEVER_TRANSACTION_ADD, $change, $extra_data);
//
//            $lever_transaction->refresh();
//            $lever_transaction->status = LeverTransaction::STATUS_CLOSED;
//            $lever_transaction->fact_profits = $profit;
//            $lever_transaction->complete_time = microtime(true);
//            $lever_transaction->closed_type = LeverTransaction::CLOSED_BY_USER_SELF; //平仓类型
//            $result = $lever_transaction->save();
//            if (!$result) {
//                throw new \Exception(__('model.平仓失败:更新处理状态失败'));
//            }
//            DB::commit();
//            $lever_trades = collect([$lever_transaction]);
//            event(new LeverClosedEvent($lever_trades));
//            echo 1;
//        } catch (\Exception $e) {
//            DB::rollBack();
//            echo $e->getMessage();
//        }
//        var_dump(self::handleUserLever(67,CurrencyMatch::find(1)));
//
//
//        try {
//            $lever_transaction = LeverTransaction::lockForupdate()->find(1154);
//            DB::beginTransaction();
//            if (empty($lever_transaction)) {
//                throw new \Exception(__('model.交易不存在'));
//            }
//            $last_price = "18248";
//            $lever_transaction->refresh();
//            // if ($lever_transaction->status != self::STATUS_TRANSACTION) {
//            //     throw new \Exception('该笔交易状态异常,不能平仓' . $lever_transaction->status);
//            // }
//            //更新状态
//            $lever_transaction->update_price = $last_price;
//            $lever_transaction->update_time = microtime(true);
//            $lever_transaction->status = LeverTransaction::STATUS_CLOSED;
//            $lever_transaction->handle_time = microtime(true);
//            $result = $lever_transaction->save();
//            if (!$result) {
//                throw new \Exception(__('model.平仓失败:锁定交易状态失败'));
//            }
//
//            $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
//
//            if (empty($legal_wallet)) {
//                throw new \Exception(__('model.钱包不存在'));
//            }
//            //计算盈亏
//            $profit = $lever_transaction->profits;
//            $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
//            //从钱包处理资金
//            $pre_result = bc($legal_wallet->balance, '+', $change);
//            $diff = 0;
//            // 是否余额不够扣除
//            if (bccomp($pre_result, 0) < 0) {
//                $change = -$legal_wallet->balance;
//                $diff = $pre_result;
//            }
//            $extra_data = [
//                'trade_id' => $lever_transaction->id,
//                'caution_money' => $lever_transaction->caution_money,
//                'profit' => $profit,
//                'diff' => $diff,
//                'mome' => '平仓资金处理',
//                'strict' => false
//            ];
//            $legal_wallet->changeBalance(AccountLog::LEVER_TRANSACTION_FROZEN, $change, $extra_data);
//
//            $lever_transaction->refresh();
//            $lever_transaction->status = LeverTransaction::STATUS_CLOSED;
//            $lever_transaction->fact_profits = $profit;
//            $lever_transaction->complete_time = microtime(true);
//            $lever_transaction->closed_type = LeverTransaction::CLOSED_BY_OUT_OF_MONEY; //平仓类型
//            $result = $lever_transaction->save();
//            if (!$result) {
//                throw new \Exception(__('model.平仓失败:更新处理状态失败'));
//            }
//            DB::commit();
//            $lever_trades = collect([$lever_transaction]);
//            event(new LeverClosedEvent($lever_trades));
//            return true;
//        } catch (\Exception $e) {
//            DB::rollBack();
//            throw $e;
//        }
//        $currencyMatch = CurrencyMatch::findOrFail(2);
//        $get_kline_symbol = $currencyMatch->lower_symbol;
//
//        $day_data = Market::getMarketDetail($get_kline_symbol);
//        $day_data['change'] = ($day_data['close'] - $day_data['open']) / $day_data['close'] * 100;
//        $day_data['change'] = bc($day_data['change'], '+', 0, 2);
//        /**@var CurrencyQuotation $quotation * */
//        $quotation = CurrencyQuotation::where('currency_match_id', $currencyMatch->id)->firstOrNew([
//            'currency_match_id' => $currencyMatch->id
//        ]);
//        var_dump($day_data);
//        $quotation->replaceLowHigh($day_data);
//        var_dump(UDunClound::supportCoins());
//        $user_id = 486;
//
//        foreach(CurrencyProtocol::get() as $k => $v ){
//
//            $currency = Currency::findOrFail($v->currency_id);
//
//            //循环创建去中心化钱包
//            foreach ($currency->currencyProtocols()->cursor() as $currencyProtocol) {
//                $blockChain = BlockChain::newInstance($currencyProtocol);
//                DB::transaction(function () use ($blockChain,$user_id) {
//
//                    $user = User::find($user_id);
//
//                    $blockChain->createOrUpdateUserAddress($user);
//
//                });
//            }
//        }
//        var_dump(Agent::agentPath("",472));
//        $txOrder = new TxOrder();
//
//        $txOrder->id = 1;
//        $txOrder->symbol = "ANTC/USDT";
//        $txOrder->currency_match_id = 20;
//        $txOrder->price = 0.0000038;
//        $txOrder->user_id = 1;
//        $txOrder->market_from = 0;
//        $txOrder->change_fee_rate = 0;
//        $txOrder->base_account_id = 20;
//        $txOrder->quote_account_id = 1;
//        $txOrder->amount = 20000;
//
//
//        MatchEngine::dispatch($txOrder, MatchEngine::MATCH, TxIn::class)
//            ->onQueue("matchEngine:1");
//
//        $txOrder = new TxOrder();
//
//        $txOrder->id = 1;
//        $txOrder->symbol = "ANTC/USDT";
//        $txOrder->currency_match_id = 20;
//        $txOrder->price = 0.0000038;
//        $txOrder->user_id = 1;
//        $txOrder->market_from = 0;
//        $txOrder->change_fee_rate = 0;
//        $txOrder->base_account_id = 20;
//        $txOrder->quote_account_id = 1;
//        $txOrder->amount = 20000;
//
//
//        MatchEngine::dispatch($txOrder, MatchEngine::MATCH, TxOut::class)
//            ->onQueue("matchEngine:1");
        //交易完成记录
        //生成随机完成单
//        $mun = 10;
//        while(true){
//            sleep(1);
//            $mun--;
//
//            if($mun<0){
//
//                return ;
//            }
//            $faker = Factory::create();
//            $amount = 5000;
//            $price =  $faker->randomFloat(9, 0.0038, 0.0040);
//            $way = mt_rand(0,1)?TxComplete::OUT:TxComplete::IN;
//            $completes = collect();
//            $currency_id = 20;
//            $amount = $faker->randomFloat(9, 1, $amount);
//            $txCompleteEntity = new TxCompleteEntity();
//            $txCompleteEntity->in_user_id = 1;
//            $txCompleteEntity->out_user_id = 1;
//            $txCompleteEntity->price = $price;
//            $txCompleteEntity->amount = $amount;
//            $txCompleteEntity->way = $way;
//            $txCompleteEntity->currency_match_id = $currency_id;
//            $completes->prepend($txCompleteEntity);
//            $depth_buys = $this->virtualDepthBuys("ANTC/USDT", $price);
//            $depth_sells = $this->virtualDepthSells("ANTC/USDT", $price);
//            $depth = new Depth("ANTC/USDT", $depth_buys, $depth_sells, $currency_id);
//
//            PushMarket::dispatch(
//                $currency_id, "ANTC/USDT",$price , $completes->take(30), $depth, CurrencyMatch::ROBOT
//            )->onQueue('pushMarket')->onConnection('sync');
//
//        }

//        $currencyMatches = Currency::with(['matches'=>function($query){
//            $query->with('currencyQuotation')->orderBy('sort');
//        }])->where('is_quote', Currency::ON)->get();
//
//        $quote = CurrencyQuotation::find(17);
//        return $this->success(__('api.请求成功'), $quote);

//        $rp = http("http://api.wftqm.com/api/sms/mtsend",[
//            'appkey'=>'cTddqGY8',
//            'secretkey'=>'9DrAjpcJ',
//            'phone'=>'85253197078',
//            'content'=>"Your verification code is 1231",
//        ],"POST",[
//            'Content-Type'=>'application/x-www-form-urlencoded'
//        ]);

//        var_dump($rp);exit;
    }



    /**虚拟买入深度
     *
     * @param     $symbol
     * @param     $price
     * @param int $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function virtualDepthBuys($symbol, $price, $limit = 10)
    {
        $decimal = 9;
        $min_price = 0.000000001;
        $faker = Factory::create();

        $buys = collect();
        for ($i = 0; $i < $limit; $i++) {
            $amount = round($faker->randomFloat(8 - $decimal, 200, 2000),8);
            $buy_price = bc($price - ($i + 1) * $min_price, '+', 0, $decimal);

            $depthSell = new DepthTx($amount, $buy_price);
            $buys->push($depthSell);
        }
        return $buys;
    }

    /**虚拟卖出深度
     *
     * @param     $symbol
     * @param     $price
     * @param int $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function virtualDepthSells($symbol, $price, $limit = 10)
    {
        $decimal = 9;
        $min_price = 0.000000001;

        $faker = Factory::create();

        $sells = collect();
        for ($i = 0; $i < $limit; $i++) {
            $amount = round($faker->randomFloat(8 - $decimal, 200, 1000),8);
            $out_price = bc($price + ($i + 1) * $min_price, '+', 0, $decimal);

            $depthSell = new DepthTx($amount, $out_price);
            $sells->push($depthSell);
        }
        return $sells;
    }


    public static function handleUserLever($user_id, $currency_match)
    {

        $quote_currency_id = $currency_match->quote_currency_id;
        try {
            $quote_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $quote_currency_id, $user_id);
            if (empty($quote_wallet)) {
                throw new \Exception(__('model.钱包不存在'));
            }
            //取交易对总盈利和总保证金
            $profit_results = LeverTransaction::getUserProfit($user_id, $quote_currency_id, 0);
            extract($profit_results);
            //是否满足爆仓条件
            $need_burst = LeverTransaction::checkBurst($quote_wallet);
            if (!$need_burst) {
                throw new \Exception(__('model.不满足爆仓条件'));
            }
            echo 1;
        } catch (\Exception $ex) {
            // $path = base_path() . '/storage/logs/lever/';
            // $filename = date('Ymd') . '.log';
            // file_exists($path) || @mkdir($path);
            // error_log(date('Y-m-d H:i:s') . ' File:' . $ex->getFile() . ', Line:' . $ex->getLine() . ', Message:' . $ex->getMessage() . PHP_EOL, 3, $path . $filename);
            return $ex->getMessage();
        }
    }

}
