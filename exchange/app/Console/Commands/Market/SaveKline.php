<?php

namespace App\Console\Commands\Market;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\Market;
use App\Models\Currency\CurrencyMatch;
use App\Models\Kline\BackupKlines;
use App\Models\Project\ProjectRobots;
use Illuminate\Console\Command;
use Workerman\Lib\Timer;

class SaveKline extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saveKline:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '保存k线';

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
        $this->worker->name = 'saveKline:worker';

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('saveKline/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            Timer::add(300, function (){

                $pj = ProjectRobots::select(['currency_match_id'])->get();

                foreach($pj as $project){

                    $currency_match_id = $project->currency_match_id;

                    $currencyMatch = CurrencyMatch::find($currency_match_id);

                    foreach(Market::PERIODS as $period){

                        $kline = Market::getKline($currencyMatch->symbol, $period);

                        if($kline->count() >= 1){

                                $res = json_encode($kline->toArray(),320);

                                BackupKlines::updateOrCreate([
                                    "period"=>$period,
                                    "currency_match_id"=>$currency_match_id,
                                ],[
                                    'kline_data'=>$res
                                ]);
                        }


                    }

                }
            });
        } catch (\Throwable $t) {
            $this->info($t->getMessage());
            $this->info($t->getFile());
            $this->info($t->getLine());
        }
    }

}
