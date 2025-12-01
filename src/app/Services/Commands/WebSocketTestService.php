<?php

namespace App\Services\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Workerman\SystemService as WorkermanSystemService;
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
        private WorkermanSystemService $workermanSystemService,
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
            'websocket' => $this->execWebsocketTest(),
            'redis' => $this->execRedisTest(),
            'workerman' => $this->execWorkermanTest(),
            default => $this->cmd->error('invalide type ' . $type),
        };
    }

    /**
     * WebSocketで送信
     */
    private function execWebsocketTest()
    {
        $data = [
            "message" => "システムからの送信（コマンド） " . date('Y-m-d h:i:s'),
        ];

        if ($this->userId) $data['target_user_id'] = $this->userId;

        $this->cmd->info("data: " . print_r($data, true));
        
        $response = $this->webSocketSystemService->sendSystemData(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);
    }

    /**
     * redis Puh/Sub経由
     */
    private function execRedisTest()
    {
        $data = [
            "message" => "システムからの送信（Redis） " . date('Y-m-d h:i:s'),
        ];

        if ($this->userId) $data['target_user_id'] = $this->userId;

        $this->cmd->info("data: " . print_r($data, true));
        
        $response = $this->webSocketSystemService->publish(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);
    }

    /**
     * Workerman用
     */
    private function execWorkermanTest()
    {
        $data = [
            "message" => "システムからの送信（WM） " . date('Y-m-d h:i:s'),
        ];

        if ($this->userId) $data['target_user_id'] = $this->userId;

        $this->cmd->info("data: " . print_r($data, true));
        
        $response = $this->workermanSystemService->sendSystemData(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);
    }
}
