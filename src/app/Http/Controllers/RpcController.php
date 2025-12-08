<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\Development\TraceService;

/**
 * RPC管理コントローラー
 */
class RpcController extends Controller
{
    public function __construct(
        private TraceService $traceService,
    ) {}

    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();
        Log::info('handle all', [$request->all(), $_REQUEST, $request->headers->all()]);

        $this->traceService->traceMiddlewareInfo();

        if ($name === 'development.frontend.start_slow_job') {
            return response()->json(
                app(\App\Services\Development\FrontendService::class)->startSlowJob(
                    $user,
                    $request->input('test'),
                    $request->input('test2'),
                )
            );
        } else if ($name === 'tweet.api.store_api') {
            return response()->json(
                app(\App\Services\Tweet\ApiService::class)->storeApi($request)
            );
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
