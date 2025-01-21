<?php

namespace App\Jobs;

use App\BlockChain\BlockChain;
use App\Models\User\User;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * CancelTxOrder constructor.
     *
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        DB::beginTransaction();
        //已弃用
        try {
            BlockChain::generateAllOnlineWallet($this->user);

        } catch (\Throwable $t) {
            DB::rollBack();
            dump($t->getMessage());
            dump($t->getFile());
            dump($t->getLine());
            return ;
        }
        DB::commit();
    }
}
