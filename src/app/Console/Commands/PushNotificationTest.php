<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PushNotification\SenderService;
use App\Services\PushNotification\NodeService;

use App\Models\PushNotification;

class PushNotificationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:push-notification-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'プッシュ通知関連のテスト用';

    public function __construct(
        private SenderService $senderService,
        private NodeService $nodeService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->execNodeTest();
        //$this->execAllTest();
    }

    /**
     * nodeの連携テスト
     */
    private function execNodeTest()
    {
        $pushNotification = PushNotification::first();

        //$this->info('pushNotification' . print_r($pushNotification, true));

        if (!$pushNotification) return;

        $this->nodeService->clear();

        $message = 'プッシュ通知テスト(node)';

        $cnt = $this->nodeService->push($message, $pushNotification);

        $this->info('cnt: ' . $cnt);
    }

    /**
     * 全件送信テスト
     */
    private function execAllTest()
    {
        $message = "テスト通知";

        $notifications = PushNotification::all();

        foreach ($notifications as $notification) {
            $result = $this->senderService->send(
                $message,
                $notification
            );

            $this->info('result: ' . print_r($result, true));
        }
    }
}
