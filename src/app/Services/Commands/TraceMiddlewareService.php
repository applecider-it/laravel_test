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
    private Command $cmd;

    public function __construct() {}

    /** 実行 */
    public function exec(Command $cmd)
    {
        $this->cmd = $cmd;

        $uri = $this->cmd->option('uri');
        $method = $this->cmd->option('method');

        $this->traceCommon();
        $this->traceRoutes($uri, $method);
    }

    /** 共通のミドルウェアのトレース */
    private function traceCommon()
    {
        $this->cmd->info("getMiddleware");
        $this->cmd->comment(print_r(app('router')->getMiddleware(), true));

        $this->cmd->info("getMiddlewareGroups");
        $this->cmd->comment(print_r(app('router')->getMiddlewareGroups(), true));
    }

    /** ルートのミドルウェアのトレース */
    private function traceRoutes($uri, $method)
    {
        $this->cmd->info("uri:[$uri], method:$method.");

        $request = Request::create($uri, $method);

        $route = null;
        try {
            $route = Route::getRoutes()->match($request);

            $this->cmd->info("gatherMiddleware");
            $this->cmd->comment(print_r($route->gatherMiddleware(), true));
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            $this->cmd->info("ルートなし");
        }
    }
}
