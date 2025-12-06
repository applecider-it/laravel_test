<?php

namespace App\Services\Tweet;

use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\User\Tweet as UserTweet;

use App\Services\WebSocket\SystemService as WebSocketSystemService;
use App\Services\Channels\TweetChannel;

/**
 * ツイートのWebsocket関連
 */
class WebsocketService
{
    public function __construct(
        private WebSocketSystemService $webSocketSystemService
    ) {}

    /**
     * 新しいツイートをブロードキャスト
     */
    public function sendNewTweet($tweetArray)
    {
        Log::info('sendNewTweet.tweetArray', [$tweetArray]);

        $data = [
            "tweet" => $tweetArray,
        ];

        $response = $this->webSocketSystemService->sendSystemData(TweetChannel::getChannel(), $data);

        Log::info('websocket_test response', [$response]);

    }
}
