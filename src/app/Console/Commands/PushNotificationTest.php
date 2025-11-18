<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PushNotification\SenderService;

class PushNotificationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:push-notification-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private SenderService $senderService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = "テスト通知";

        $this->senderService->sendAll($message);
    }
}
