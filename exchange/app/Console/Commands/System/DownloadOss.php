<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class DownloadOss extends Command
{
    const COMMANDS = [
        'match:loadOrder',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '下载oss上面的文件';

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


    }


}
