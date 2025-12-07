<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Commands\AiTestService;

class AiTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ai-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AIサーバー接続の動作確認用';

    public function __construct(
        private AiTestService $aiTestService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->aiTestService->exec($this);
    }
}
