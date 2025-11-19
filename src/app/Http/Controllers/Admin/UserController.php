<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\Admin\User\ListService;

class UserController extends Controller
{
    public function __construct(
        private ListService $listService
    ) {}

    // ユーザー一覧
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = $this->listService->getUsers($search);

        // 検索条件を保持したままページネーション
        $users = $query->paginate(5)->withQueryString();

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
        $user = new User();
        $validated = $request->validate(
            rules: [
                'name'  => $user->validationName(),
                'email' => $user->validationEmail(),
                'password' => $user->validationPassword(),
            ],
            attributes: [
                'name' => __('app.models.user.columns.name'),
                'email' => __('app.models.user.columns.email'),
                'password' => __('app.models.user.columns.password'),
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
                'name'  => $user->validationName(),
                'email' => $user->validationEmail(),
                'password' => $user->validationPassword(true),
            ],
            attributes: [
                'name' => __('app.models.user.columns.name'),
                'email' => __('app.models.user.columns.email'),
                'password' => __('app.models.user.columns.password'),
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
