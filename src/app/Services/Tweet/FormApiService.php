<?php

namespace App\Services\Tweet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\User\TweetResource;

/**
 * ツイートのフォームApiのプロセスの管理
 */
class FormApiService
{
    public function __construct(
        private FormService $tweetFormService,
        private WebsocketService $tweetWebsocketService,
    ) {}

    /** Tweet追加処理 */
    public function storeTweet(Request $request)
    {
        $validation = $this->tweetFormService->newTweetValidation();
        $validated = $request->validate(
            rules: $validation['rules'],
            attributes: $validation['attributes']
        );

        $user = $request->user();
        $content = $validated['content'];

        $tweet = $this->tweetFormService->newTweet($user, $content);

        $tweetResource = new TweetResource($tweet->load('user'));

        $tweetArray = $tweetResource->toArray(request());

        Log::info('tweetResource', [$tweetResource]);
        Log::info('tweetResource->toArray', [$tweetArray]);

        $this->tweetWebsocketService->sendNewTweet($tweetArray);

        return $tweetResource;
    }

}
