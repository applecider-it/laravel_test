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

        $rooms = [
            'default',
            'room1',
            'room2',
        ];

        $room = $request->input('room');
        if (!in_array($room, $rooms)) $room = 'default';

        $token = $this->webSocketAuthService->createUserJwt($user, ChatChannel::getChannel($room));

        return view('chat.index', compact('token', 'room', 'rooms'));
    }
}
