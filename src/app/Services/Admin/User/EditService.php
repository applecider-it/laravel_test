<?php

namespace App\Services\Admin\User;

use App\Models\User;

/**
 * 管理画面のユーザー管理の編集関連
 */
class EditService
{
    /**
     * 関連するツイート一覧（論理削除含む）
     */
    public function getTweets(User $user)
    {
        $tweets = $user->tweets()
            ->latest()
            ->withTrashed();

        return $tweets;
    }
}
