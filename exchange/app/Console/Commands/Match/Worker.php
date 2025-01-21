<?php

namespace App\Console\Commands\Match;

use App\Console\Commands\Socket\InitArgument;
use App\Exceptions\ThrowException;
use App\Jobs\AsyncChangeBalance;
use App\Jobs\MatchEngine;
use App\Logic\Robot;
use App\Logic\SocketPusher;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\ChangeAccount;
use App\Models\Account\ChangeAccountLog;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Group\UserGroup;
use App\Models\Tx\TxIn;
use App\Models\Tx\TxOut;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Workerman\Lib\Timer;
use App\Models\Tx\Robot as RobotModel;

class Worker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '傻瓜撮合主进程';

    /**
     * @var \Workerman\Worker
     */
    protected $worker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initArgv();

        $this->worker = new \Workerman\Worker();
        $this->worker->count = 1;
        $this->worker->name = 'match:worker';
        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];
        //设置pid路径
        $path = storage_path('match/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            Timer::add(3, function () {

                $quo_source = CurrencyQuotation::select(['currency_match_id','close'])->get();

                foreach($quo_source as $key => $quo){

                    $in_price = $quo->close * 0.993;
                    $out_price = $quo->close * 1.01;
                    $fee = 0;

                    try {
                        DB::beginTransaction();
                        $orderIn = TxIn::where("currency_match_id",$quo->currency_match_id)
                            ->with("currencyMatch")->where("price",">=",$in_price)->get();
                        foreach($orderIn as $k => $v){

//                            $rate = $v->change_fee_rate;
//                            $fee = bc($amount, '*', $rate);

                            //计算金额
                            $volume = bc($v->price, '*', $v->number);
                            $rate = $v->currencyMatch->change_fee_rate;

                            //计算手续费
                            $fee = bc($v->number, '*', $rate);
                            $v->number = $v->number - $fee;

                            //买方加交易币金额,减少计价币
                            $this->changeBalance(ChangeAccountLog::TX_MATCH,$v->number,$v->base_account_id);
                            $this->changeBalance(ChangeAccountLog::TX_MATCH,-$volume,$v->quote_account_id, AccountLog::IS_LOCK);

                            $order = TxIn::lockForUpdate()->find($v->id);
                            $order->update([
                                'transacted_volume' => bc($order->transacted_volume, '+', $volume),
                                'transacted_amount' => bc($order->transacted_amount, '+', $v->number),
                                'fee' => $fee,
                            ]);
                            TxIn::lockForUpdate()->find($v->id)->delete();
                            @SocketPusher::txOrderMatched($order->toArray(), MatchEngine::WAY_NAME[MatchEngine::IN]);
                        }

                        DB::commit();
                    }catch(\Exception $exception){
                        DB::rollBack();
                    }
                    try {
                        DB::beginTransaction();

                        $orderOut = TxOut::where("currency_match_id",$quo->currency_match_id)
                            ->with("currencyMatch")->where("price","<=",$out_price)->get();
                        foreach($orderOut as $k => $v){

                            //计算金额
                            $volume = bc($v->price, '*', $v->number);

                            $rate = $v->currencyMatch->change_fee_rate;
                            $fee = bc($volume, '*', $rate);
                            $volume = $volume - $fee;
                            //卖方加计价币金额,减少交易币
                            $this->changeBalance(ChangeAccountLog::TX_MATCH,$volume,$v->quote_account_id);
                            $this->changeBalance(ChangeAccountLog::TX_MATCH,-$v->number,$v->base_account_id, AccountLog::IS_LOCK);

                            $order = TxOut::lockForUpdate()->find($v->id);
                            $order->update([
                                'transacted_volume' => bc($order->transacted_volume, '+', $volume),
                                'transacted_amount' => bc($order->transacted_amount, '+', $v->number),
                                'fee' => $fee,
                            ]);

                            TxOut::lockForUpdate()->find($v->id)->delete();
                            @SocketPusher::txOrderMatched($order->toArray(), MatchEngine::WAY_NAME[MatchEngine::OUT]);

                        }
                        DB::commit();
                    }catch(\Exception $exception){

                        DB::rollBack();
                    }

                }
            });
        } catch (\Throwable $t) {
            $this->info($t->getMessage());
            $this->info($t->getFile());
            $this->info($t->getLine());
        }
    }

    public function changeBalance($log_type ,$number, $account_id,$is_lock = AccountLog::NO_LOCK)
    {
        try {
            DB::transaction(function () use($account_id,$is_lock,$log_type,$number){
                /**
                 * @var  $account Account
                 */
                $account = ChangeAccount::lockForUpdate()->find($account_id);
                if (!$account) {
                    return;
                }

                if ($is_lock==AccountLog::IS_LOCK) {
                    $account->changeLockBalance($log_type, $number);
                } else {
                    $account->changeBalance($log_type, $number);
                }
            });
        } catch (\Throwable $t) {
            throw new ThrowException($t->getMessage());
        }
    }

    /**获取买入手续费,返回扣过手续费的金额
     *
     * @param TxIn $order
     * @param float $amount 成交量
     * @param float $fee 手续费
     *
     * @return bool|string|null
     */
    public function getInFee($order,$amount, &$fee)
    {
        $rate = $order->currencyMatch->change_fee_rate;
        $fee = bc($amount, '*', $rate);
        $amount = bc($amount, '-', $fee);
        return $amount;
    }
}
