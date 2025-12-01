<?php

namespace App\Services\Commands;

use Illuminate\Console\Command;

use App\Services\PushNotification\SenderService;
use App\Services\PushNotification\NodeService;

use App\Models\User;
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
    public function exec(Command $cmd)
    {
        $this->cmd = $cmd;

        $type = $this->cmd->argument('type');
        $userId = (int) $this->cmd->argument('user_id');

        $this->cmd->info("type: {$type}");
        $this->cmd->info("userId: {$userId}");

        $user = User::find($userId);

        if (! $user) {
            $this->cmd->info('対象のユーザーが見つかりません。');
            return;
        }

        $this->cmd->info("user name: {$user->name}");

        $options = [
            'type' => 'progress',
            'notice' => true,
            //'message' => true,
        ];

        $this->cmd->info("options: " . json_encode($options, JSON_UNESCAPED_UNICODE));

        match ($type) {
            'redis' => $this->execRedisTest($user, $options),
            'laravel' => $this->execLaravelTest($user, $options),
            default => $this->cmd->error('invalide type ' . $type),
        };
    }

    /**
     * nodeの一斉送信用に、Redisに追加
     */
    private function execRedisTest(User $user, array $options)
    {
        $noclear = $this->cmd->option('noclear');

        if (! $noclear) {
            $this->nodeService->clear();
            $this->cmd->info('redisをclearしました');
        }

        $message = 'プッシュ通知テスト(node)';

        $cnt = $this->nodeService->pushByUser(
            $message,
            $user,
            $options
        );

        $this->cmd->info('redisの送信対象件数: ' . $cnt);
    }

    /**
     * Laravelから送信
     */
    private function execLaravelTest(User $user, array $options)
    {
        $message = "テスト通知";

        $result = $this->senderService->sendByUser(
            $message,
            $user,
            $options
        );

        $this->cmd->info('result: ' . print_r($result, true));
    }
}
