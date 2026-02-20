<?php

namespace App\Services\Development;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Services\Data\Json;

/**
 * 開発用トレース管理
 */
class TraceService
{
    /**
     * ミドルウェア情報をログに出力
     */
    public function traceMiddlewareInfo()
    {
        // ログ出力が標準出力の場合に、print_rだと一部表示されなくなるので、Json::traceを利用している。

        Log::info('getMiddleware', [Json::trace(app('router')->getMiddleware(), true)]);
        Log::info('getMiddlewareGroups', [Json::trace(app('router')->getMiddlewareGroups(), true)]);

        $currentRoute = Route::current(); // 現在のルート
        // 適用されている全ミドルウェア
        Log::info('gatherMiddleware', [Json::trace($currentRoute->gatherMiddleware(), true)]);
    }
}
