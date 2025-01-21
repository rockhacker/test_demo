<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Models\Account\{Account, AccountType,  AccountLog};
use App\Models\Lever\LeverTransaction;
use App\Events\Lever\LeverClosedEvent;

class DeductBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $quote_currency_id;
    private $user_id;
    private $log_type;
    private $change;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id,$quote_currency_id,$log_type, $change, $data)
    {
        $this->user_id = $user_id;
        $this->quote_currency_id = $quote_currency_id;
        $this->log_type = $log_type;
        $this->change = $change;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            try {
                DB::transaction(function () {
                    try {
                        $quote_wallet = Account::getAccountByType(AccountType::LEVER_ACCOUNT_ID, $this->quote_currency_id, $this->user_id);

                        $quote_wallet->changeBalance($this->log_type, $this->change, $this->data);

                    } catch (\Exception $e) {
                        throw $e;
                    }
                });
            } catch (\Exception $e) {
                throw $e;

            }
    }

}
