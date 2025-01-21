<?php

namespace App\Console\Commands\UStandard;

use App\Console\Commands\Socket\InitArgument;
use App\Models\Currency\CurrencyMatch;
use App\Models\Lever\LeverUStandard;
use App\Models\Tx\Robot as RobotModel;
use Illuminate\Console\Command;

class Worker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uStandardUpdate:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新订单价格主进程';

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
        $this->worker->name = 'uStandardUpdate:worker';//

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('uStandardUpdate/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        $this->robot = RobotModel::where('process_id', $this->worker->id)->first();
        if (!$this->robot) {
            $this->info('机器人不存在pid:' . $this->worker->id);
            return false;
        }else{
            $this->info('已查找到机器人:' . $this->worker->id);
        }
        $currency_match = $this->robot->currencyMatch;
        if(empty($currency_match)){
            $this->info('[' .date('Y-m-d H:i:s') . ']' . ' worker id ' . $this->worker->id . ' 未找到交易对 ');
            return false;
        }

        $this->info('match id :' . $currency_match->id . ' num: '  . $this->worker->count . '/' . $this->worker->id . " 启动");
        while (true){

            $now = microtime(true);
            LeverUStandard::newPrice($currency_match, $now);
            $this->info('[' .date('Y-m-d H:i:s') . ']' . ' price   symbol '  . $currency_match->symbol);

            sleep(1);
        }

    }


}
