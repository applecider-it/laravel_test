<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\AuthService as WebSocketAuthService;

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

    public function index()
    {
        $user = auth()->user();

        $token = $this->webSocketAuthService->createUserJwt($user, \App\Services\Channels\ChatChannel::CHANNEL_ID);

        return view('chat.index', compact('token'));
    }
}
