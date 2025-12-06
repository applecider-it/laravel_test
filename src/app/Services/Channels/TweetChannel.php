<?php

namespace App\Services\Channels;

class TweetChannel{
    private const CHANNEL_ID = 'tweet';

    /** チャンネル名を返す */
    public static function getChannel() {
        return self::CHANNEL_ID . ':';
    }
}