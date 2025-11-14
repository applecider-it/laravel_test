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
    protected $signature = 'app:web-socket-test {--token=}';

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
        $token = $this->option('token');
        $this->info("TOKEN = {$token}");

        $data = [
            "message" => "hello from Laravel Command",
        ];

        if ($token) $data['target_token'] = $token;

        $sendData = [
            "data" => $data,
            "channel" => "chat",
        ];

        $this->info("sendData: " . print_r($sendData, true));
        
        $response = $this->webSocketSystemService->sendSystemData($sendData);

        Log::info('websocket_test response', [$response]);
    }
}
