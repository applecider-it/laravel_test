<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis受信テスト';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Redis::subscribe(['broadcast'], function (string $message) {
            echo $message;
        });
    }
}