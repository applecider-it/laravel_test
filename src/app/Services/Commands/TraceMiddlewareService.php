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

    /**
     * 実行
     */
    public function exec(Command $cmd)
    {
        $conf = [
            ['/', 'GET'],
            ['/api/development/chat_callback_test', 'POST'],
        ];

        echo "getMiddleware\n";
        print_r(app('router')->getMiddleware());
        echo PHP_EOL;

        echo "getMiddlewareGroups\n";
        print_r(app('router')->getMiddlewareGroups());
        echo PHP_EOL;

        foreach ($conf as $row) {
            $uri = $row[0];
            $method = $row[1];

            echo "uri:[$uri], method:$method.\n";

            $request = Request::create($uri, $method);

            $route = null;
            try {
                $route = Route::getRoutes()->match($request);
            } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
                echo "ルートなし\n";
                continue;
            }

            echo "gatherMiddleware\n";
            print_r($route->gatherMiddleware());
            echo PHP_EOL;
        }
    }
}
