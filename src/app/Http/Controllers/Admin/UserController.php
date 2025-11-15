<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ユーザー一覧
    public function index(Request $request)
    {
        $query = User::query();

        // フリーワード検索
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 検索条件を保持したままページネーション
        $users = $query->latest()->paginate(1)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    // 作成フォーム
    public function create()
    {
        return view('admin.users.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $validated = $request->validate(
            rules: [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ],
            attributes: [
                'name' => '名前',
                'email' => 'メールアドレス',
                'password' => 'パスワード',
            ]
        );

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'ユーザーを作成しました');
    }

    // 編集フォーム
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 更新処理
    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            rules: [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ],
            attributes: [
                'name' => '名前',
                'email' => 'メールアドレス',
                'password' => 'パスワード',
            ]
        );

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'ユーザーを更新しました');
    }

    // 削除処理
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ユーザーを削除しました');
    }
}
