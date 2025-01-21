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

class LeverPushTradeConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:leverPushTradeConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推送订单';

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
        $channel->queue_declare(ConnectRattleMq::$leverPushTradeConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            $param = json_decode($msg->body);

            $this->userId = $param->user_id;
            $currency_match =  $param->currency_match;

            try {
                //推送用户风险率和订单
                $user_account = LeverAccount::where('user_id', $this->userId)
                    ->where('currency_id', $currency_match->quote_currency_id)
                    ->first();
                if (!$user_account) {
                    throw new \Exception('钱包不存在');
                }
                //取盈亏总额
                list(
                    'caution_money_total' => $caution_money_all,
                    'origin_caution_money_total' => $origin_caution_money_all,
                    'profits_total' => $profits_all
                    ) = LeverTransaction::getUserProfit($this->userId, $currency_match->quote_currency_id);
                //取该交易对盈亏总额
                list(
                    'caution_money_total' => $caution_money,
                    'origin_caution_money_total' => $origin_caution_money,
                    'profits_total' => $profits
                    ) = LeverTransaction::getUserProfit($this->userId, $currency_match->quote_currency_id, $currency_match->base_currency_id);
                //取风险率
                $hazard_rate = LeverTransaction::getAccountHazardRate($user_account);

                //取用户所有持仓交易
                $lever_transaction_all = LeverTransaction::where('status', LeverTransaction::STATUS_TRANSACTION)
                    ->where('currency_match_id', $currency_match->id)
                    ->where('user_id', $this->userId)
                    ->orderBy('id', 'desc')
                    ->get();
                //委托中交易
                $lever_transaction_entrust = LeverTransaction::where('status', LeverTransaction::STATUS_ENTRUST)
                    ->where('currency_match_id', $currency_match->id)
                    ->where('user_id', $this->userId)
                    ->orderBy('id', 'desc')
                    ->get();
                //取交易对持仓交易
                $lever_transaction_cur = LeverTransaction::where('status', LeverTransaction::STATUS_TRANSACTION)
                    ->where('currency_match_id', $currency_match->id)
                    ->where('user_id', $this->userId)
                    ->orderBy('id', 'desc')
                    ->get();
                $push_data = [
                    'type' => 'lever_trade',
                    'to' => $this->userId,
                    'currency_match_id' => $currency_match->id,
                    'currency_match_name' => $currency_match->lower_symbol,
                    'currency_match_id',
                    'hazard_rate' => $hazard_rate, //风险率
                    'caution_money_all' => $caution_money_all, //总保证金
                    'origin_caution_money_all' => $origin_caution_money_all, //原始总保证金
                    'profits_all' => $profits_all, //总盈亏
                    'caution_money' => $caution_money, //当前交易对的保证金
                    'origin_caution_money' => $origin_caution_money, //当前交易对的原始保证金
                    'profits' => $profits, //当前交易对的盈亏金额
                    'trades_all' => $lever_transaction_all, //所有交易
                    'trades_entrust' => $lever_transaction_entrust, //取所有委托交易
                    'trades_cur' => $lever_transaction_cur, //当前交易对的交易
                ];
                @SocketPusher::leverTrade($push_data, $this->userId);

            } catch (\Exception $e) {
                echo '文件:' . $e->getFile() . PHP_EOL;
                echo '行号:' . $e->getLine() . PHP_EOL;
                echo '错误:' . $e->getMessage() . PHP_EOL;
            }
        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$leverPushTradeConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }
}



