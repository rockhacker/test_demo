<?php

namespace App\Console\Commands\Lever;

use App\Console\Commands\Socket\InitArgument;
use App\Models\Currency\CurrencyMatch;
use App\Models\Lever\LeverTransaction;
use App\Models\Lever\LeverUStandard;
use App\Models\Tx\Robot as RobotModel;
use Illuminate\Console\Command;

class TradeHandleWorker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leverHandle:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理订单价格主进程';

    /**
     * @var \Workerman\Worker
     */
    protected $worker;

    protected $currency_matches;

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
        $this->worker->count = 30;//一个交易对一个进程
        $this->worker->name = 'leverHandle:worker';//

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('leverHandle/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        $currency_match = CurrencyMatch::where('process_id',$this->worker->id)->first();
        if(empty($currency_match)){
            $this->info('[' .date('Y-m-d H:i:s') . ']' . ' worker id ' . $this->worker->id . ' 未找到交易对 ');
            return false;
        }
        $this->info('match id :' . $currency_match->id . ' num: '  . $this->worker->count . '/' . $this->worker->id . " 启动");
        while (true){
            $this->info('symbol :' . $currency_match->symbol . ' num: '  . $this->worker->count . '-->' . $this->worker->id . " 执行");

            LeverTransaction::tradeHandle($currency_match);
            $this->info('[' .date('Y-m-d H:i:s') . '] symbol '  . $currency_match->symbol . ' 执行结束');

            sleep(1);
        }

    }


}
