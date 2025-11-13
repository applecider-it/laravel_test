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
