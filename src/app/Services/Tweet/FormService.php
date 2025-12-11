<?php

namespace App\Services\Tweet;

use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\User\Tweet as UserTweet;

use App\Http\Resources\User\TweetResource;

/**
 * ツイートのフォーム関連
 */
class FormService
{
    public function __construct(
        private WebsocketService $tweetWebsocketService,
    ) {}

    /**
     * 指定したユーザーの新しいツイート作成時のバリデーション情報
     */
    public function newTweetValidation()
    {
        $tweet = new UserTweet();
        return [
            'rules' => [
                'content' => $tweet->validation_content(),
            ],
            'attributes' => [
                'content' => __('app.models.user/tweet.columns.content')
            ]
        ];
    }

    /**
     * 指定したユーザーの新しいツイート作成
     */
    public function newTweet(User $user, string $content)
    {
        $tweet = $user->tweets()->create([
            'content' => $content,
        ]);

        $tweetResource = new TweetResource($tweet->load('user'));

        $tweetArray = $tweetResource->toArray(request());

        $this->tweetWebsocketService->sendNewTweet($tweetArray);

        Log::info('tweetResource', [$tweetResource]);
        Log::info('tweetResource->toArray', [$tweetArray]);

        return [
            'tweet' => $tweet,
            'tweetResource' => $tweetResource,
        ];
    }
}
