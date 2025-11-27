<?php

namespace App\Services\Commands;

use Illuminate\Console\Command;

use App\Services\PushNotification\SenderService;
use App\Services\PushNotification\NodeService;

use App\Models\PushNotification;

/**
 * プッシュ通知関連のテスト用
 */
class PushNotificationTestService
{
    private Command $cmd;

    public function __construct(
        private SenderService $senderService,
        private NodeService $nodeService,
    ) {}

    /**
     * 実行
     */
    public function exec(Command $cmd) {
        $this->cmd = $cmd;

        $type = $this->cmd->argument('type');

        match($type){
            'node' => $this->execNodeTest(),
            'take' => $this->execTakeTest(),
            default => $this->cmd->error('invalide type ' . $type),
        };
    }

    /**
     * nodeの一斉送信用に、Redisに追加
     */
    private function execNodeTest()
    {
        $pushNotification = PushNotification::first();

        //$this->info('pushNotification' . print_r($pushNotification, true));

        if (!$pushNotification) return;

        $noclear = $this->cmd->option('noclear');

        if (! $noclear) {
            $this->nodeService->clear();
            $this->cmd->info('redisをclearしました');    
        }

        $message = 'プッシュ通知テスト(node)';

        $cnt = $this->nodeService->push($message, $pushNotification);

        $this->cmd->info('redisの送信対象件数: ' . $cnt);
    }

    /**
     * 数件だけLaravelから送信
     */
    private function execTakeTest()
    {
        $message = "テスト通知";

        $notifications = PushNotification::take(2)->get();

        foreach ($notifications as $notification) {
            $result = $this->senderService->send(
                $message,
                $notification
            );

            $this->cmd->info('result: ' . print_r($result, true));
        }
    }
}
