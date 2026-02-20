<?php

namespace App\Services\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 * ミドルウェアのトレース
 */
class TraceMiddlewareService
{
    public function __construct() {}

    /** 実行 */
    public function exec(Command $cmd)
    {
        $this->traceCommon();
        $this->traceRoutes();
    }

    /** 共通のミドルウェアのトレース */
    private function traceCommon()
    {
        echo 'getMiddleware' . PHP_EOL;
        print_r(app('router')->getMiddleware());
        echo PHP_EOL;

        echo 'getMiddlewareGroups' . PHP_EOL;
        print_r(app('router')->getMiddlewareGroups());
        echo PHP_EOL;
    }

    /** ルートごとのミドルウェアのトレース */
    private function traceRoutes()
    {
        $routes = config('myapp.trace_middleware_command.routes');

        foreach ($routes as $row) {
            $uri = $row[0];
            $method = $row[1];

            echo "uri:[$uri], method:$method." . PHP_EOL;

            $request = Request::create($uri, $method);

            $route = null;
            try {
                $route = Route::getRoutes()->match($request);
            } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
                echo 'ルートなし' . PHP_EOL;
                echo PHP_EOL;
                continue;
            }

            echo 'gatherMiddleware' . PHP_EOL;
            print_r($route->gatherMiddleware());
            echo PHP_EOL;
        }
    }
}
