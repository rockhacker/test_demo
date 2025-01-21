<?php

namespace App\Console\Commands\Subscription;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\FundWorker;
use App\Logic\Robot;
use App\Logic\SubscriptionWorker;
use App\Models\Currency\CurrencyQuotation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
    protected $signature = 'subscription:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新币发币程序';

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
        $this->worker->name = 'subscription:worker';

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('subscription/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            $robot = new SubscriptionWorker($this->worker->id, $this);
            Timer::add(30, function () use ($robot) {
                $robot->run();
            });
        } catch (\Throwable $t) {
            $this->info($t->getMessage());
            $this->info($t->getFile());
            $this->info($t->getLine());
        }
    }


}
