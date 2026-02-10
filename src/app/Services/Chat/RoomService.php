<?php

namespace App\Services\Chat;

use Illuminate\Support\Facades\Log;

/**
 * チャットのRoom管理
 */
class RoomService
{
    /** チャットRoom情報 */
    public function getRoomInfo(?string $room)
    {
        $rooms = [
            'default',
            'room1',
            'room2',
        ];

        if (!in_array($room, $rooms)) $room = 'default';

        return [
            'room' => $room,
            'rooms' => $rooms,
        ];
    }
}
