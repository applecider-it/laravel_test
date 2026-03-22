<?php

namespace App\Services\Tweet;

use App\Models\User\Tweet as UserTweet;

/**
 * ツイートの一覧関連
 */
class ListService
{
    /**
     * 一覧用のツイートリストオブジェクト
     */
    public function getTweetsForList(?string $searchWord)
    {
        $tweets = UserTweet::with('user');
        
        if (!empty($searchWord)) {
            $tweets->where('content', 'like', "%{$searchWord}%");
        }
        $tweets->orderBy('id', 'desc');
        $tweets->latest();

        return $tweets;
    }
}
