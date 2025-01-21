<?php


namespace App\Console\Commands\Micro;

use AMQPExchange;
use App\Logic\ConnectRattleMq;
use App\Logic\MicroTrade;
use App\Logic\SocketPusher;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class MicroCloseConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'micro:microCloseConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '秒合约订单平仓推送';

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
        $channel->queue_declare(ConnectRattleMq::$microCloseConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            $param = json_decode($msg->body);
            try {
                SocketPusher::microClosed($param);

            }catch(\Throwable $exception){

                echo "处理秒合约订单推送错误:".$exception->getMessage().PHP_EOL;
            }

        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$microCloseConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }
}



