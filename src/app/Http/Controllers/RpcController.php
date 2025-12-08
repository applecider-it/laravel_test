<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * RPC管理コントローラー
 */
class RpcController extends Controller
{
    /** RPCルート定義 */
    protected array $routes = [
        'development.frontend.start_slow_job' => [
            \App\Services\Development\FrontendService::class,
            'startSlowJob',
        ],
    ];

    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();

        if (isset($this->routes[$name])) {
            // ルート定義があるとき

            [$class, $method] = $this->routes[$name];
            $obj = app($class);

            $result = match ($name) {
                'development.frontend.start_slow_job' => $obj->$method(
                    $user,
                    $request->input('test'),
                    $request->input('test2'),
                ),
                default => $obj->$method(),
            };

            return response()->json($result);
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
