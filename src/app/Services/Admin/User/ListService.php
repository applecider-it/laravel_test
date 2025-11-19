<?php

namespace App\Services\Admin\User;

use App\Models\User as User;

/**
 * 管理画面のユーザー管理の一覧関連
 */
class ListService
{
    /**
     * 一覧用のリストオブジェクト
     */
    public function getUsers(?string $search)
    {
        $query = User::query();

        $query->latest()->withTrashed();

        // フリーワード検索
        if ($search) $query->searchKeyword($search);

        return $query;
    }
}
