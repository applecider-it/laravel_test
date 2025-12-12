<?php

namespace App\Http\Controllers\Rpc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

/**
 * チャットRPC管理コントローラー
 */
class ChatRpcController extends Controller
{
    public function __construct(
    ) {}

    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();

        if ($name === 'send_message') {
            return response()->json(
                app(\App\Services\Chat\FormApiService::class)->sendMessage($request, $user)
            );
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
