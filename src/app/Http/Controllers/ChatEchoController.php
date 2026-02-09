<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * チャット(Echo)管理コントローラー
 * 
 * ドキュメント
 * /documents/features/chat.md
 */
class ChatEchoController extends Controller
{
    public function __construct() {}

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

        return view('chat_echo.index', compact('room', 'rooms'));
    }
}
