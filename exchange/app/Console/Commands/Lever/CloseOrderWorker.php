<?php

namespace App\Console\Commands\Lever;

use App\Console\Commands\Socket\InitArgument;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Lever\LeverTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class CloseOrderWorker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:closeOrderWorker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '平仓服务';

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
        $this->worker->count = 1;//
        $this->worker->name = 'lever:closeOrderWorker';//

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('closeOrderWorker/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            while (true) {
                $data = LeverTransaction::where("status", LeverTransaction::STATUS_CLOSING)->get();
                $count = count($data);
                if(empty($data) || $count < 1){
                    sleep(1);
                    continue;
                }
                $this->info(date('Y-m-d H:i:s') .' 执行平仓任务' . count($data) . '条');
                try {
                    DB::beginTransaction();

                    foreach ($data as $key => $lever_transaction) {

                        $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
//                        $legal_wallet = Account::getAccountByType(AccountType::CHANGE_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);

                        if (empty($legal_wallet)) {
                            throw new \Exception(__('model.钱包不存在'));
                        }

                        $profit = $lever_transaction->profits;
                        $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
                        $pre_result = bc($legal_wallet->balance, '+', $change);
                        $diff = 0;

                        $extra_data = [
                            'trade_id' => $lever_transaction->id,
                            'caution_money' => $lever_transaction->caution_money,
                            'profit' => $profit,
                            'diff' => $diff,
                            'mome' => '平仓资金处理',
                            'strict' => false
                        ];

                        // 爆仓已经扣过了
                        if($lever_transaction->closed_type != LeverTransaction::CLOSED_BY_OUT_OF_MONEY){

                            $legal_wallet->changeBalance(AccountLog::LEVER_TRANSACTION_ADD, $change, $extra_data);
                        }

                        $lever_transaction->refresh();
                        $lever_transaction->status = LeverTransaction::STATUS_CLOSED;
                        $lever_transaction->fact_profits = $profit;
                        $lever_transaction->complete_time = microtime(true);
                        $lever_transaction->closed_type = $lever_transaction->closed_type ?? LeverTransaction::CLOSED_BY_USER_SELF; //平仓类型
                        $result = $lever_transaction->save();
                        if (!$result) {
                            throw new \Exception(__('model.平仓失败:更新处理状态失败'));
                        }
                    }
                    DB::commit();

                } catch (\Exception $e) {
                    DB::rollBack();
                }

                $this->info('执行平仓任务' . count($data) . '条 ， 执行结束');


            }
        } catch (\Throwable $t) {
            $this->error($t->getMessage());
            $this->error($t->getFile());
            $this->error($t->getLine());
            throw new $t;
        }
    }

}
