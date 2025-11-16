<?php

namespace App\Services\Tweet;

use App\Models\User;
use App\Models\User\Tweet as UserTweet;

/**
 * ツイートのフォーム関連
 */
class FormService
{
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

        return $tweet;
    }
}
