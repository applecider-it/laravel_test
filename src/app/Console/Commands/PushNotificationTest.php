<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Commands\PushNotificationTestService;

class PushNotificationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:push-notification-test 
                        {type : 実行タイプ (take = 数件だけLaravelから送信 / node = nodeの一斉送信用に、Redisに追加)}
                        {--noclear : typeがnodeの場合、redisをクリアをしたくないときに指定する}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'プッシュ通知関連のテスト用';

    public function __construct(
        private PushNotificationTestService $pushNotificationTestService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->pushNotificationTestService->exec($this);
    }
}
