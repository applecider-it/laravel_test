<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ChatChannel;

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
            "message" => "hello from Laravel Command " . date('Y-m-d h:i:s'),
        ];

        if ($token) $data['target_token'] = $token;

        $this->info("data: " . print_r($data, true));
        
        $response = $this->webSocketSystemService->sendSystemData(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);
    }
}
