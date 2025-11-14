<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;

class WebSocketTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:web-socket-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WebSocketの動作確認用';

    public function __construct(
        private WebSocketSystemService $webSocketSystemService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            "data" => [
                "message" => "hello from Laravel Command",
            ],
            "channel" => "chat",
        ];
        
        $response = $this->webSocketSystemService->sendSystemData($data);

        Log::info('websocket_test response', [$response]);
    }
}
