<?php

namespace App\Console\Commands\Micro;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\Market;
use App\Logic\MicroTrade;
use App\Logic\SocketPusher;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Commission\OrderCommission;
use App\Models\Micro\MicroOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Workerman\Lib\Timer;
use Illuminate\Support\Carbon;

class MicroAddWorker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'micro:addWorker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '下单服务';

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
//        $this->resetRobotPrice();

        $this->worker = new \Workerman\Worker();
        $this->worker->count = 20;//
        $this->worker->name = 'micro:addWorker';//

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('microAddWorker/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        $key = 'micro_add_queue';
        $this->info($this->worker->id . '启动');
        try {
            while (true) {
                $param = Redis::lPop($key);
                $param = json_decode($param,true);
                if(isset($param['retry']) && $param['retry'] > 3){
                    $this->error('订单id ：' . json_encode($param) . ' 重试次数已达上限');
                    return false;
                }
                if(!empty($param)){
                    try {
                        $order = MicroTrade::addOrder($param);
                        $this->info('订单id 执行成功 : ' . $order->id);
                    } catch (\Throwable $t) {
                        $this->error($t->getMessage());
                        if(!isset($param['retry'])) $param['retry'] = 0;
                        $param['retry'] = $param['retry'] +1;
                        Redis::rPush($key,json_encode($param));
                    }
                } else {
                    sleep(1);
                }
            }
        } catch (\Throwable $t) {
            $this->error($t->getMessage());
            $this->error($t->getFile());
            $this->error($t->getLine());
        }
    }

}
