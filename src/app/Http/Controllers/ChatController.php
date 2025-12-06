<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Services\Channels\ChatChannel;

/**
 * チャット管理コントローラー
 * 
 * ドキュメント
 * /documents/features/chat.md
 */
class ChatController extends Controller
{
    public function __construct(
        private WebSocketAuthService $webSocketAuthService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        $token = $this->webSocketAuthService->createUserJwt($user, ChatChannel::getChannel($request->input('room')));

        return view('chat.index', compact('token'));
    }
}
