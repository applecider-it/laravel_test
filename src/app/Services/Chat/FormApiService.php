<?php

namespace App\Services\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\ChatChannel;

use App\Models\User;

/**
 * チャットのフォームApiのプロセスの管理
 */
class FormApiService
{
    public function __construct(
        private WebSocketSystemService $webSocketSystemService,
    ) {}

    /** チャットメッセージ送信処理 */
    public function sendMessage(Request $request, User $user)
    {
        $room = $request->input('room');
        $data = [
            "message" => $request->input('message'),
            "name" => $user->name,
        ];

        $response = $this->webSocketSystemService->publish(ChatChannel::getChannel($room), $data);

        return $response;
    }

}
