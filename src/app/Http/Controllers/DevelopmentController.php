<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    /** viewテスト */
    public function view_test(Request $request)
    {
        return view('development.view_test', $this->view_test_common());
    }
    public function view_test_post(Request $request)
    {
        return redirect()->back()->withInput();
    }
    private function view_test_common()
    {
        $list_val = 2;
        $radio_val = 'val2';
        $datetime_val = '2026-02-15T14:30';
        $list_vals = [
            1 => 'No. 1',
            2 => 'No. 2',
            3 => 'No. 3',
        ];
        $radio_vals = [
            'val1' => 'Value 1',
            'val2' => 'Value 2',
        ];
        return compact(
            'list_val',
            'radio_val',
            'datetime_val',
            'list_vals',
            'radio_vals'
        );
    }

    /** javascriptテスト */
    public function javascript_test(Request $request)
    {
        return view(
            'development.javascript_test',
            ['formData' => $this->view_test_common()]
        );
    }

    /** uploadテスト */
    public function upload_test(Request $request)
    {
        $path = $request->file('file')->store('uploads');

        return response()->json(['path' => $path]);
    }

    /** websocketテスト */
    public function websocket_test(Request $request)
    {
        $user = auth()->user();

        $token = $this->webSocketAuthService->createUserJwt($user, ProgressChannel::getChannel($user->id));
        return view(
            'development.websocket_test',
            compact('token')
        );
    }
}
