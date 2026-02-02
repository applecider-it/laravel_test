<?php

namespace App\Http\Controllers\Rpc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\Development\TraceService;

use App\Http\Controllers\Controller;

/**
 * 開発者向けページRPC管理コントローラー
 */
class DevelopmentRpcController extends Controller
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

        if ($name === 'start_slow_job') {
            return response()->json(
                app(\App\Services\Development\JavascriptTestService::class)->startSlowJob(
                    $user,
                    $request->input('test'),
                    $request->input('test2'),
                )
            );
        } else if ($name === 'send_test_channel') {
            return response()->json(
                app(\App\Services\Development\JavascriptTestService::class)->sendTestChannel(
                    $request->input('message'),
                    (int) $request->input('user_id'),
                )
            );
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
