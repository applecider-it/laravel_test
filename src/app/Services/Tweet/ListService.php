<?php

namespace App\Services\Tweet;

use App\Models\Tweet;

/**
 * ツイートの一覧関連
 */
class ListService
{
    /**
     * 一覧用のツイートリストオブジェクト
     */
    public function getTweetsForList(?string $searchWord, ?string $sort, ?string $sortType)
    {
        $tweets = Tweet::with('user');
        
        if (!empty($searchWord)) {
            $tweets->where('content', 'like', "%{$searchWord}%");
        }
        $tweets->orderBy($sort, $sortType);
        $tweets->latest();

        return $tweets;
    }
}
