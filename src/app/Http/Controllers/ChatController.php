<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Services\Channels\ChatChannel;
use App\Services\Chat\RoomService;

/**
 * チャット管理コントローラー
 * 
 * ドキュメント
 * /documents/features/chat.md
 */
class ChatController extends Controller
{
    public function __construct(
        private WebSocketAuthService $webSocketAuthService,
        private RoomService $roomService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        $room = $request->input('room');

        $ret = $this->roomService->getRoomInfo($room);

        $room = $ret['room'];
        $rooms = $ret['rooms'];

        $token = $this->webSocketAuthService->createUserJwt($user, ChatChannel::getChannel($room));

        return view('chat.index', compact('token', 'room', 'rooms'));
    }
}
