<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Data\Json;
use App\Services\PushNotification\NodeService;

class ReceivePushResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:receive-push-result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nodeのプッシュ通知の結果を受け取る';

    public function __construct(
        private NodeService $nodeService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Begin!!!");

        $results = $this->nodeService->revievePushNotificationResults();

        $this->info("Results: " . Json::trace($results, true));
    }
}
