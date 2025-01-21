<?php

namespace App\Console\Commands\Lever;

use App\Logic\Market;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Currency\CurrencyMatch;
use App\Models\Lever\LeverTransaction;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CloseOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lever:closeOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '平仓';

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
        try {
            DB::beginTransaction();
            $data = LeverTransaction::lockForupdate()->where("status", LeverTransaction::STATUS_CLOSING)->get();

            foreach ($data as $key => $lever_transaction) {


//            $legal_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);
                $legal_wallet = Account::getAccountByType(AccountType::CHANGE_ACCOUNT_ID, $lever_transaction->quote_currency_id, $lever_transaction->user_id);

                if (empty($legal_wallet)) {
                    throw new Exception(__('model.钱包不存在'));
                }
                $profit = $lever_transaction->profits;
                $change = bc($lever_transaction->caution_money, '+', $profit); //算上本金
                $pre_result = bc($legal_wallet->balance, '+', $change);
                $diff = 0;

                $extra_data = [
                    'trade_id' => $lever_transaction->id,
                    'caution_money' => $lever_transaction->caution_money,
                    'profit' => $profit,
                    'diff' => $diff,
                    'mome' => '平仓资金处理',
                    'strict' => false
                ];
                $legal_wallet->changeBalance(AccountLog::LEVER_TRANSACTION_ADD, $change, $extra_data);
                $lever_transaction->refresh();
                $lever_transaction->status = LeverTransaction::STATUS_CLOSED;
                $lever_transaction->fact_profits = $profit;
                $lever_transaction->complete_time = microtime(true);
                $lever_transaction->closed_type = LeverTransaction::CLOSED_BY_USER_SELF; //平仓类型
                $result = $lever_transaction->save();
                if (!$result) {
                    throw new \Exception(__('model.平仓失败:更新处理状态失败'));
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
        }

        $this->info('完成');
    }
}
