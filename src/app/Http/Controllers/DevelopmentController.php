<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Services\Channels\ProgressChannel;
use App\Services\Sample\SampleService;
use App\Services\Development\TraceService;

use App\Events\SampleEvent;

/**
 * 開発者向けページ用コントローラー
 */
class DevelopmentController extends Controller
{
    public function __construct(
        private SampleService $sampleService,
        private TraceService $traceService,
        private WebSocketAuthService $webSocketAuthService
    ) {}

    public function index(Request $request)
    {
        return view('development.index');
    }

    /** phpテスト */
    public function php_test(Request $request)
    {
        $user = $request->user();

        $this->traceService->traceMiddlewareInfo();

        Redis::set('redis-test', 'TEST');

        event(new SampleEvent($user));

        $this->sampleService->testExec("php_test");

        return view('development.complate');
    }

    /** javascriptテスト */
    public function javascript_test(Request $request)
    {
        $user = auth()->user();

        $token = $this->webSocketAuthService->createUserJwt($user, ProgressChannel::getChannel($user->id));
        return view('development.javascript_test', compact('token'));
    }
}
