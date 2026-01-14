<?php

namespace App\Services\Channels;

class ChatChannel{
    private const CHANNEL_ID = 'chat';

    /** チャンネル名を返す */
    public static function getChannel(?string $room) {
        return self::CHANNEL_ID . ':' . $room;
    }
}