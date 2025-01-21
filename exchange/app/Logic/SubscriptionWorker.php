<?php


namespace App\Logic;

use App\BlockChain\BlockChain;
use App\Console\Commands\Robot\Worker;
use App\Entity\Market\Depth;
use App\Entity\Market\DepthTx;
use App\Entity\TxCompleteEntity;
use App\Entity\TxOrder;
use App\Jobs\ClearTxOrder;
use App\Jobs\MatchEngine;
use App\Jobs\PushMarket;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Currency\CurrencyMatch;
use App\Models\Fund\Funds;
use App\Models\Fund\SubFund;
use App\Models\Fund\SubFundInterest;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionOrders;
use App\Models\Tx\Robot as RobotModel;
use App\Models\Tx\TxComplete;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SubscriptionWorker
{

    /**
     * @var Worker
     */
    protected $command;


    public function __construct($process_id, $command)
    {
        $this->command = $command;
        $this->command->info('新币发币程序开始:pid:' . $process_id);
    }

    public function run()
    {
        try {
            $interest_time = date("Y-m-d H:i:s");
            $this->command->info('运行' . now()->toDateTimeString());

            DB::beginTransaction();

            //找出一条未发币但是需要发币的申购
            $sub = Subscription::lockForUpdate()
                ->where("status", '=', 0)
                ->where("market_time", "<=", $interest_time)
                ->first();

            if (empty($sub->id)) {
                DB::rollBack();
                return;
            }

            //找出申购的进行发币
            $res = SubscriptionOrders::where("sub_id", $sub->id)
                ->where("is_return", 0)
                ->get();

            foreach ($res as $order) {

                switch ($order->status) {
                    //待抽签和未中签的进行处理
                    case 1:
                    case 2:

                        SubscriptionOrders::where("id", $order->id)->update([
                            "status" => 2,  //统一改为未中签
                            "is_return" => 3//全额退款
                        ]);
                        //进行全额的退款
                        $legal = Account::getAccountByType(
                            AccountType::CHANGE_ACCOUNT_ID,
                            $order->pay_currency_id,
                            $order->user_id
                        );
                        $legal->changeBalance(AccountLog::SUBSCRIPTION_REF, $order->pay_amount);

                        break;
                    //中签处理
                    case 3:
                        $update = [];

                        //如果中签但是小于申购数量需要进行部分退款
                        if ($order->winning_lots_number < $order->number) {

                            $exc_amount = $order->number - $order->winning_lots_number;

                            //退款的金额
                            $re_amount = round($order->pay_amount * ($exc_amount / $order->number), 8);

                            Account::getAccountByType(
                                AccountType::CHANGE_ACCOUNT_ID,
                                $order->pay_currency_id,
                                $order->user_id
                            )->changeBalance(AccountLog::SUBSCRIPTION_REF, $re_amount);

                            //部分退款
                            $update['is_return'] = 2;
                        }

                        $exc_amount = $order->winning_lots_number;
                        //发币
                        $update['status'] = 4;

                        Account::getAccountByType(
                            AccountType::CHANGE_ACCOUNT_ID,
                            $sub->currency_id,
                            $order->user_id
                        )->changeBalance(AccountLog::ISSUED_COINS, $exc_amount);

                        SubscriptionOrders::where("id", $order->id)->update($update);

                        break;
                }

            }
            $sub->status = 1;
            $sub->save();
            DB::commit();

        } catch (\Throwable $t) {
            DB::rollBack();
            dump($t->getMessage());
            dump($t->getFile());
            dump($t->getLine());
        }

    }

}
