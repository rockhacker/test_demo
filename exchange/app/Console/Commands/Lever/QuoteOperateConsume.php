<?php


namespace App\Console\Commands\Lever;

use App\Logic\ConnectRattleMq;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Wire\AMQPTable;

class QuoteOperateConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:quoteOperateConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '合约行情的处理';

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
        START:
        $conn = ConnectRattleMq::conn();
        $channel = $conn->channel();

        try{
            $arguments = new AMQPTable();
            $arguments->set("x-message-ttl", 1000);
            $channel->queue_declare(ConnectRattleMq::$quoteOperateConsume, false, false, false, true, false, $arguments);

            $callback = function ($msg){
                $param = json_decode($msg->body);

                if (bc($param->now_price,'>', '0') ) {
                    LeverTransaction::newPrice($param->currency_match, $param->now_price, $param->now);
                }
            };
            $channel->basic_qos(null,1,null);

            //不需要确认消息
            $channel->basic_consume(ConnectRattleMq::$quoteOperateConsume,"",false,true,false,false,$callback);

            while($channel->is_consuming()){
                $channel->wait();
            }


        }catch(Exception $exception){

            echo "发生错误：".$exception->getMessage();
            goto START;
        }
        $channel->close();
        $conn->close();
    }
}



