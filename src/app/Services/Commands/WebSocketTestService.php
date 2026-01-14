<?php

namespace App\Services\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ChatChannel;

/**
 * WebSocket関連のテスト用
 */
class WebSocketTestService
{
    private Command $cmd;
    private ?int $userId;

    public function __construct(
        private WebSocketSystemService $webSocketSystemService,
    ) {}

    /**
     * 実行
     */
    public function exec(Command $cmd) {
        $this->cmd = $cmd;

        $type = $this->cmd->argument('type');
        
        $this->userId = $this->cmd->option('user_id');
        if ($this->userId) $this->userId = (int) $this->userId;

        $this->cmd->info("userId = {$this->userId}");

        match($type){
            'redis' => $this->execRedisTest(),
            default => $this->cmd->error('invalide type ' . $type),
        };
    }

    /**
     * redis Puh/Sub経由
     */
    private function execRedisTest()
    {
        $data = [
            "message" => "システムからの送信（Redis） " . date('Y-m-d h:i:s'),
            "name" => "システム管理者（Redis）",
        ];

        if ($this->userId) $data['target_user_id'] = $this->userId;

        $this->cmd->info("data: " . print_r($data, true));
        
        $response = $this->webSocketSystemService->publish(ChatChannel::getChannel('default'), $data);

        Log::info('websocket_test response', [$response]);
    }
}
