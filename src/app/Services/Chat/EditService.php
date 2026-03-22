<?php

namespace App\Services\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ChatChannel;

use App\Models\User;

/**
 * チャットの編集の管理
 */
class EditService
{
    public function __construct(
        private WebSocketSystemService $webSocketSystemService,
    ) {}

    /** RPCからチャットメッセージ送信処理 */
    public function rpcSendMessage(Request $request, User $user)
    {
        Log::info(request()->all());
        $room = $request->input('room');
        $data = [
            "message" => $request->input('message'),
            "name" => $user->name,
        ];

        $response = $this->webSocketSystemService->publish(ChatChannel::getChannel($room), $data);

        return $response;
    }
}
