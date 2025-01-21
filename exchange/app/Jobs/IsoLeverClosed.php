<?php

namespace App\Jobs;

use App\Logic\SocketPusher;
use App\Models\Iso\IsoLever;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IsoLeverClosed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    protected $isoLever;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($isoLever)
    {
        $this->isoLever = $isoLever;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        try {
            SocketPusher::isoLeverClosed($this->isoLever);
        } catch (\Throwable $t) {
            print_info($t->getMessage());
            print_info($t->getFile());
            print_info($t->getLine());
        }
    }
}
