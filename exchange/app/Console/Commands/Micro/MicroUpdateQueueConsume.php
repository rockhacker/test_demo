<?php


namespace App\Console\Commands\Micro;

use AMQPExchange;
use App\Logic\ConnectRattleMq;
use App\Logic\MicroTrade;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class MicroUpdateQueueConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'micro:microUpdateQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '秒合约行情';

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
     * @throws Exception
     */
    public function handle()
    {
        $conn = ConnectRattleMq::conn();
        $channel = $conn->channel();
        $arguments = new AMQPTable();

        $arguments->set("x-message-ttl", 1000);
        $channel->queue_declare(ConnectRattleMq::$microUpdateQueueConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            $param = json_decode($msg->body);
            try {
                $match_id = $param->currency_match_id;
                $startTime = microtime(true);
                MicroTrade::close($match_id, $param->close);
                $end_time = microtime(true);
                $log = [
                    'match_id' => $match_id,
                    'close' => $param->close,
                    'start_time' => $startTime,
                    'end_time' => $end_time,
                    'slice' => $end_time - $startTime . ' s',
                ];
                file_put_contents('/www/wwwroot/test_exchange/close.log',json_encode($log));
            }catch(\Throwable $exception){

                echo "处理秒合约行情错误:".$exception->getMessage().PHP_EOL;
            }

        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$microUpdateQueueConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }
}



