<?php

namespace App\Http\Controllers\Rpc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

/**
 * チャット(Echo)RPC管理コントローラー
 */
class ChatEchoRpcController extends Controller
{
    public function __construct(
    ) {}

    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();

        if ($name === 'send_message') {
            return response()->json(
                app(\App\Services\ChatEcho\FormApiService::class)->sendMessage($request, $user)
            );
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
