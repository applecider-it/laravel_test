<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Commands\TraceMiddlewareService;

class TraceMiddleware extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trace-middleware
                        {--uri=/ : URI}
                        {--method=GET : リクエストメソッド}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ミドルウェアのトレース';

    public function __construct(
        private TraceMiddlewareService $traceMiddlewareService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->traceMiddlewareService->exec($this);
    }
}
