<?php

namespace App\Console\Commands\ProjectRobot;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\ProjectRobot;
use Illuminate\Console\Command;
use Workerman\Lib\Timer;

class Worker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projectRobot:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '项目机器人';

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
        $this->worker->count = 20;//默认10个机器人进程
        $this->worker->name = 'projectRobot:worker';//默认10个机器人进程

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('projectRobot/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            $robot = new ProjectRobot($this->worker->id, $this);
            Timer::add(1, function () use ($robot) {
                $robot->run();
            });
        } catch (\Throwable $t) {
            $this->info($t->getMessage());
            $this->info($t->getFile());
            $this->info($t->getLine());
        }
    }

}
