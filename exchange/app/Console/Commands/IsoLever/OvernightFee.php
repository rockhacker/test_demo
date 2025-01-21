<?php

namespace App\Console\Commands\IsoLever;

use App\Models\Iso\IsoLever;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OvernightFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isoLever:overnightFee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach (IsoLever::where('status', IsoLever::STATUS_TX)->cursor() as $order) {
            try {
                DB::transaction(function () use ($order) {
                    /**@var $order IsoLever* */

                    $order->overnightFee();
                });
            } catch (\Throwable $t) {
                $this->error($t->getMessage());
                $this->error($t->getFile());
                $this->error($t->getLine());
            }
        }
    }
}
