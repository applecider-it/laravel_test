<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Development\FrontendService;

class RpcController extends Controller
{
    protected array $conf = [
        'development.frontend.start_slow_job' => [FrontendService::class, 'startSlowJob'],
    ];

    public function handle(Request $request, string $name)
    {
        if (! isset($this->conf[$name])) {
            return response()->json(['error' => 'Prc name not found'], 404);
        }

        $arr = $this->conf[$name];
        $class = $arr[0];
        $method = $arr[1];
        $obj = app($class);

        $ret = $obj->$method();

        return response()->json($ret);
    }
}
