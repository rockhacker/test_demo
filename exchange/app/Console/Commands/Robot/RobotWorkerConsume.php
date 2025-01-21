<?php


namespace App\Console\Commands\Robot;

use AMQPExchange;
use App\Entity\Market\Depth;
use App\Entity\TxCompleteEntity;
use App\Events\Market\DepthEvent;
use App\Logic\ConnectRattleMq;
use App\Logic\Market;
use App\Logic\MicroTrade;
use App\Logic\SocketPusher;
use App\Models\Currency\CurrencyMatch;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class RobotWorkerConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:robotWorkerConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '机器人行情处理';

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
     * @var int
     */
    protected $currency_match_id;

    /**
     * @var int
     */
    protected $symbol;

    /**
     * @var float
     */
    protected $close;

    /**
     * @var Collection
     */
    protected $completes;

    /**成交量
     *
     * @var float
     */
    protected $volume = 0;

    /**成交额
     *
     * @var float
     */
    protected $amount = 0;

    /**深度
     *
     * @var Depth
     *
     */
    protected $depth = null;

    /**行情来自哪里
     *
     * @var int
     *
     */
    protected $market_from = CurrencyMatch::EXCHANGE;

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
        $channel->queue_declare(ConnectRattleMq::$robotWorkerConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            try {
                $param = json_decode($msg->body);
                $this->currency_match_id = $param->currency_match_id;
                $this->symbol = $param->symbol;
                $this->close = $param->close;
                $this->completes = collect($param->completes);
                foreach($this->completes as $key => $enter){
                    /**@var TxCompleteEntity $enter * */

                    $txCompleteEntity = new TxCompleteEntity();
                    $txCompleteEntity->in_user_id = $enter->currency_match_id;
                    $txCompleteEntity->out_user_id = $enter->currency_match_id;
                    $txCompleteEntity->price = $enter->price;
                    $txCompleteEntity->amount = $enter->amount;
                    $txCompleteEntity->way = $enter->way;
                    $txCompleteEntity->currency_match_id = $enter->currency_match_id;

                    $this->completes[$key] = $txCompleteEntity;
                }

                $this->depth = $param->depth;
                $this->market_from = $param->market_from;
                $this->handleKline();

            }catch(\Throwable $throwable){

                echo "推送行情错误:".$throwable->getMessage().PHP_EOL;
            }

        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$robotWorkerConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handleKline()
    {


        if ($this->close) {
            //推送市场概要
            $this->pushDayMarket();
            //推送k线
            $this->pushKline();
            //推送全站交易
            $this->pushGlobalTx();
        }
        //推送深度
        $this->pushDepth();
        //写入到数据库
        $this->writeMarketToDB();

    }

    /**推送交易概要
     *
     */
    public function pushDayMarket()
    {
        $timestamp = now()->timestamp;

        $this->completes = $this->completes->transform(function ($complete) use ($timestamp) {
            /**@var TxCompleteEntity $complete * */
            $this->volume = $complete->volume;
            $this->amount = $complete->amount;
            $complete->timestamp = $timestamp;
            return $complete;
        });

//        $quotation->updateQuotation($this->close, $this->volume, $this->amount);

//        SocketPusher::dayMarket($this->symbol, $quotation, $this->currency_match_id);
    }

    /**推送全站交易
     *
     * @throws \Exception
     */
    public function pushGlobalTx()
    {
        //推送全站交易
        if($this->completes->isEmpty()){
            return;
        }
        SocketPusher::globalTx($this->symbol, $this->completes, $this->currency_match_id);
    }

    /**推送k线
     *
     */
    public function pushKline()
    {

        Market::handleKline($this->currency_match_id, $this->symbol, $this->close, $this->amount, $this->market_from);
    }

    /**推送深度
     *
     * @throws \Exception
     */
    public function pushDepth()
    {
        if (!$this->depth) {
            $this->depth = new Depth($this->symbol, null, null, $this->currency_match_id);
            $this->depth->in = Market::depthBuys($this->symbol);
            $this->depth->out = Market::depthSells($this->symbol);
        }
        event(new DepthEvent($this->depth, $this->market_from));
    }

    /**写入到数据库
     *
     */
    public function writeMarketToDB()
    {

    }
}



