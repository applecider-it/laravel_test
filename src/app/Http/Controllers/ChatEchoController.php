<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Chat\RoomService;

/**
 * チャット(Echo)管理コントローラー
 * 
 * ドキュメント
 * /documents/features/chat.md
 */
class ChatEchoController extends Controller
{
    public function __construct(
        private RoomService $roomService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        $room = $request->input('room');

        $ret = $this->roomService->getRoomInfo($room);

        $room = $ret['room'];
        $rooms = $ret['rooms'];

        return view('chat_echo.index', compact('room', 'rooms'));
    }
}
