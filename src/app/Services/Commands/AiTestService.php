<?php

namespace App\Services\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\AI\AiService;

/**
 * WebSocket関連のテスト用
 */
class AiTestService
{
    private Command $cmd;

    public function __construct(
        private AiService $aiService,
    ) {}

    /**
     * 実行
     */
    public function exec(Command $cmd)
    {
        $this->cmd = $cmd;

        $response = $this->aiService->testSend();

        $this->cmd->info('response' . json_encode($response, JSON_UNESCAPED_UNICODE));
    }
}
