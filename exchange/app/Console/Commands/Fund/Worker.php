<?php

namespace App\Console\Commands\Fund;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\FundWorker;
use App\Logic\Robot;
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
    protected $signature = 'fund:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '锁仓生息返息程序';

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
        $this->worker->name = 'fund:worker';

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('fund/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            $robot = new FundWorker($this->worker->id, $this);
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
