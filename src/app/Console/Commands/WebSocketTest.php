<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Commands\WebSocketTestService;

class WebSocketTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:web-socket-test
                                {type : 実行タイプ (redis = redis Puh/Sub経由)}
                                {--user_id= : 送信ユーザーを限定する時}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WebSocketの動作確認用';

    public function __construct(
        private WebSocketTestService $webSocketTestService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->webSocketTestService->exec($this);
    }
}
