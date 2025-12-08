<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * RPC管理コントローラー
 */
class RpcController extends Controller
{
    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();

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
