<?php

namespace App\Jobs;

use App\Console\Commands\IsoLever\Worker;
use App\Models\Iso\IsoLever;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class IsoLeverPushPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currency_match_id;

    protected $close;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($currency_match_id, $close)
    {
        $this->close = $close;
        $this->currency_match_id = $currency_match_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Worker::http(Worker::METHOD_ON_MARKET, [
                'currency_match_id' => $this->currency_match_id,
                'close' => $this->close,
            ]);
        } catch (\Throwable $t) {
            print_info($t->getMessage());
            print_info($t->getFile());
            print_info($t->getLine());
        }
    }

}
