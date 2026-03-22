<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User\Tweet as UserTweet;
use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Services\Channels\TweetChannel;
use \App\Http\Resources\User\TweetResource;

/**
 * ツイート(JS)管理コントローラー
 * 
 * ドキュメント
 * /documents/features/tweet.md
 */
class TweetJsController extends Controller
{
    public function __construct(
        private WebSocketAuthService $webSocketAuthService
    ) {}

    /** 一覧ページ(JS) */
    public function index(Request $request)
    {
        $user = $request->user();
        $tweets = UserTweet::with('user')->latest()->take(20)->get();

        $token = $this->webSocketAuthService->createUserJwt($user, TweetChannel::getChannel());

        $tweetsResource = TweetResource::collection($tweets);

        return view('tweet_js.index', compact('tweetsResource', 'token', 'user'));
    }
}
