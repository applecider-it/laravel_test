<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\Workerman\SystemService as WorkermanSystemService;
use App\Services\Channels\ChatChannel;

class WebSocketWorkermanTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:web-socket-workerman-test {--token=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WebSocket(WM)の動作確認用';

    public function __construct(
        private WorkermanSystemService $workermanSystemService
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
            "message" => "システムからの送信（WM） " . date('Y-m-d h:i:s'),
        ];

        if ($token) $data['target_token'] = $token;

        $this->info("data: " . print_r($data, true));
        
        $response = $this->workermanSystemService->sendSystemData(ChatChannel::CHANNEL_ID, $data);

        Log::info('websocket_test response', [$response]);
    }
}
