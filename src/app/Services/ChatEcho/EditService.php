<?php

namespace App\Services\ChatEcho;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User;

/**
 * チャット(Echo)の編集の管理
 */
class EditService
{
    public function __construct() {}

    /** RPCからEchoでチャットメッセージ送信処理 */
    public function rpcSendMessage(Request $request, User $user)
    {
        $room = $request->input('room');
        $message = $request->input('message');
        $options = $request->input('options');

        $others = $options['others'] ?? false;

        Log::info("sendMessageEcho options", [$options, $others]);

        //event(new \App\Events\ChatMessageSent($message, $room, $user));
        $obj = broadcast(new \App\Events\ChatMessageSent($message, $room, $user));

        if ($others) $obj->toOthers();
    }
}
