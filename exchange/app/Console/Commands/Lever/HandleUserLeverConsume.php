<?php


namespace App\Console\Commands\Lever;

use AMQPExchange;
use App\Logic\ConnectRattleMq;
use App\Logic\SocketPusher;
use App\Models\Account\LeverAccount;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class HandleUserLeverConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:handleUserLeverConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理用户合约订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected $userId ;
    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
//        ConnectRattleMq::publish_send(ConnectRattleMq::$quoteOperateConsume,["123"]);
//        return 1;
        $conn = ConnectRattleMq::conn();
        $channel = $conn->channel();
        $arguments = new AMQPTable();

        $arguments->set("x-message-ttl", 1000);
        $channel->queue_declare(ConnectRattleMq::$handleUserLeverConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            $param = json_decode($msg->body);

            $this->userId = $param->user_id;
            try {
                LeverTransaction::handleUserLever($this->userId, $param->currency_match);
            } catch (\Throwable $t) {
                dump($t->getMessage());
                dump($t->getLine());
                dump($t->getFile());
            }
        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$handleUserLeverConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }
}



