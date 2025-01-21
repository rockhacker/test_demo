<?php


namespace App\Console\Commands\Lever;

use AMQPExchange;
use App\Logic\ConnectRattleMq;
use App\Logic\SocketPusher;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Account\LeverAccount;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class LeverCloseConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:leverCloseConsume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '合约订单平仓';

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
        $conn = ConnectRattleMq::conn();
        $channel = $conn->channel();
        $arguments = new AMQPTable();

        $arguments->set("x-message-ttl", 1000);
        $channel->queue_declare(ConnectRattleMq::$leverCloseConsume, false, false, false, true, false, $arguments);
        $callback = function ($msg){
            $param = json_decode($msg->body);
            $lever_transactions = LeverTransaction::whereIn('id', $param->affect_result)
                ->where('status', LeverTransaction::STATUS_CLOSING)
                ->get();
            foreach ($lever_transactions as $key => $trade) {
                try {
                    DB::transaction(function () use ($trade,$param) {
                        try {
                            if ($param->deduct_balance) {
                                if (!$this->deductBalance($trade)) {
                                    throw new \Exception('平仓扣除资金失败');
                                }
                            }
                            //更新状态和计算最终盈利
                            $trade->status = LeverTransaction::STATUS_CLOSED;
                            $trade->fact_profits = $trade->profits;
                            $trade->complete_time = microtime(true);
                            $result = $trade->save();

                            if (!$result) {
                                throw new \Exception('平仓失败:更新平仓状态失败');
                            }
                        } catch (\Exception $e) {
                            throw $e;
                        }
                    });
                } catch (\Exception $e) {
                    echo 'File:' . $e->getFile() . PHP_EOL;
                    echo 'Line:' . $e->getLine() . PHP_EOL;
                    echo 'Message:' . $e->getMessage() . PHP_EOL;
                }
            }
        };
        $channel->basic_qos(null,1,null);

        //不需要确认消息
        $channel->basic_consume(ConnectRattleMq::$leverCloseConsume,"",false,true,false,false,$callback);

        while($channel->is_consuming()){
            $channel->wait();
        }
        $channel->close();
        $conn->close();
    }

    public function deductBalance($trade)
    {
        try {
            DB::transaction(function () use ($trade) {

                $lever_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $trade->quote_currency_id, $trade->user_id);

                //计算盈亏
                $change = bc($trade->caution_money, '+', $trade->profits);
                //从钱包处理资金
                $pre_result = bc($lever_wallet->balance, '+', $change);
                $diff = 0;

                $type = AccountLog::LEVER_TRANSACTION_ADD;
                //是否余额不够扣除
                if (bccomp($pre_result, '0') < 0) {
//                    $change = -$lever_wallet->balance;
//                    $diff = $pre_result;
                    $type = AccountLog::LEVER_TRANSACTION_FROZEN;
                }

                $extra_data = [
                    'trade_id' => $trade->id,
                    'caution_money' => $trade->caution_money,
                    'profit' => $trade->profits,
                    'diff' => $diff,
                ];
                $data = ['strict' => false, 'data' => $extra_data];

                $lever_wallet->changeBalance($type, $change, $data);
            });
            return true;
        } catch (\Exception $e) {
            echo 'File:' . $e->getFile() . PHP_EOL;
            echo 'Line:' . $e->getLine() . PHP_EOL;
            echo 'Message:' . $e->getMessage() . PHP_EOL;
            return false;
        }
    }
}



