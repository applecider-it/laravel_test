<?php

namespace App\Services\Tweet;

use App\Models\Tweet;
use App\Models\User;

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
        $tweet = new Tweet();
        return [
            'rules' => [
                'content' => $tweet->validation_content(),
            ],
            'attributes' => [
                'content' => __('models.tweet.columns.content')
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
