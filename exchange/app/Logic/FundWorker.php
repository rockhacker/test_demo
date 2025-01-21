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
use App\Models\Tx\Robot as RobotModel;
use App\Models\Tx\TxComplete;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FundWorker
{

    /**
     * @var Worker
     */
    protected $command;




    public function __construct($process_id, $command)
    {
        $this->command = $command;
        $this->command->info('返利息程序开始:pid:' . $process_id);
    }

    public function run()
    {
        try {
            $interest_time = date("Y-m-d H:i:s");
            $this->command->info('运行' . now()->toDateTimeString());

            $sub = SubFund::lockForUpdate()
                ->where("status",'<=',2)
                ->where("is_return",0)
                ->where("interest_gen_next_time","<=",$interest_time)
                ->where("surplus_period",">",0)
                ->get();

            foreach($sub as $order){
                try{

                    DB::beginTransaction();
                    $fund = Funds::where("id",$order->fund_id)->first();

                    if(!$fund){

                        continue;
                    }

                    $surplus_period = $order->surplus_period - 1;

                    $interest = round($order->share_amount * ($fund->dividend_percentage / 100),6);

                    $legal = Account::getAccountByType(
                        AccountType::CHANGE_ACCOUNT_ID,
                        $fund->currency_id,
                        $order->user_id
                    );

                    //返利息
//                    $legal->changeLockBalance(AccountLog::SUB_INTEREST,$interest);
                    $legal->changeBalance(AccountLog::SUB_INTEREST,$interest);
                    $fund_amount = $order->fund_amount + $interest;
                    $is_return = 0;
                    //订单结束
                    if($surplus_period == 0){

                        //本金和利息退还
//                        $legal->changeLockBalance(AccountLog::SUB_PRINCIPAL_INTEREST,-($order->share_amount+$fund_amount));
//                        $legal->changeBalance(AccountLog::SUB_PRINCIPAL_INTEREST,($order->share_amount+$fund_amount));
//本金退还
                        $legal->changeLockBalance(AccountLog::SUB_PRINCIPAL_INTEREST,-($order->share_amount));
                        $legal->changeBalance(AccountLog::SUB_PRINCIPAL_INTEREST,($order->share_amount));

                        $is_return = 1;
                    }

                    SubFund::where("id",$order->id)->update([
                        'surplus_period'=>$surplus_period,
                        'interest_gen_next_time'=>Funds::gen_next_time(),
                        'fund_amount'=>$fund_amount,
                        'status'=>$surplus_period == 0 ? 4 : $order->status,
                        'is_return'=>$is_return,
                    ]);

                    SubFundInterest::create([
                        "sub_id"=>$order->id,
                        'fund_id'=>$order->fund_id,
                        'user_id'=>$order->user_id,
                        'interest'=>$interest
                    ]);

                    DB::commit();
                }catch(\Exception $exception){
                    DB::rollBack();
                    throw new \Exception($exception->getMessage());
                }

            }



        } catch (\Throwable $t) {
            dump($t->getMessage());
            dump($t->getFile());
            dump($t->getLine());
        }

    }

}
