<?php

namespace App\Services\Development;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 * 開発用トレース管理
 */
class TraceService{
    /**
     * ミドルウェア情報をログに出力
     */
    public function traceMiddlewareInfo()
    {
        Log::info('getMiddleware', [print_r(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [print_r(app('router')->getMiddlewareGroups(), true)]);

        $currentRoute = Route::current(); // 現在のルート
        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [print_r($currentRoute->gatherMiddleware(), true)]);
    }
}