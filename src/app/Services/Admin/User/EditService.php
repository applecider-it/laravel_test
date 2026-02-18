<?php

namespace App\Services\Admin\User;

use Illuminate\Support\Facades\Hash;

/**
 * 管理画面のユーザー管理の編集関連
 */
class EditService
{
    /** 更新データの変更 */
    public function updateValidated(array &$validated)
    {
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    }
}
