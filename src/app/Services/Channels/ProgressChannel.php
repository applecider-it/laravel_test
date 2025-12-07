<?php

namespace App\Services\Channels;

class ProgressChannel{
    private const CHANNEL_ID = 'progress';

    /** チャンネル名を返す */
    public static function getChannel(int $userId) {
        return self::CHANNEL_ID . ':' . $userId;
    }
}