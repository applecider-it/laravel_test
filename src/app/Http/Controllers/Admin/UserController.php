<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Services\Admin\User\ListService;
use App\Services\Admin\User\EditService;

/**
 * ユーザー管理コントローラー
 */
class UserController extends Controller
{
    public function __construct(
        private ListService $listService,
        private EditService $editService
    ) {}

    /** 一覧 */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = $this->listService->getUsers($search);

        // 検索条件を保持したままページネーション
        $users = $query->paginate(5)->onEachSide(2)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    /** 新規作成 */
    public function create()
    {
        $user = new User();
        return view('admin.users.create', compact('user'));
    }

    /** 登録処理 */
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
                'name' => __('myapp.models.user.columns.name'),
                'email' => __('myapp.models.user.columns.email'),
                'password' => __('myapp.models.user.columns.password'),
            ]
        );

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('admin.users.edit', $user)->with('success', 'ユーザーを作成しました');
    }

    /** 編集 */
    public function edit($id)
    {
        $user = $this->getUser($id);

        $tweets = $this->listService->getTweets($user);

        $tweets = $tweets->paginate(5, pageName: 'tweets_page')->onEachSide(2);

        return view('admin.users.edit', compact('user', 'tweets'));
    }

    /** 更新処理 */
    public function update(Request $request, $id)
    {
        $user = $this->getUser($id);

        $validated = $request->validate(
            rules: [
                'name'  => $user->validationName(),
                'email' => $user->validationEmail(),
                'password' => $user->validationPassword(true),
            ],
            attributes: [
                'name' => __('myapp.models.user.columns.name'),
                'email' => __('myapp.models.user.columns.email'),
                'password' => __('myapp.models.user.columns.password'),
            ]
        );

        $this->editService->updateValidated($validated);

        $user->update($validated);

        return redirect()->route('admin.users.edit', $user)->with('success', 'ユーザーを更新しました');
    }

    /** 論理削除 */
    public function destroy($id)
    {
        $user = $this->getUser($id);

        $user->delete();

        return redirect()->route('admin.users.edit', $user)->with('success', 'ユーザーを削除しました');
    }

    /** 復元 */
    public function restore($id)
    {
        $user = $this->getUser($id);

        $user->restore();

        return redirect()->route('admin.users.edit', $user)->with('success', 'ユーザーを復元しました');
    }

    /**
     * 論理削除されたユーザーを含んで取得
     * 
     * 論理削除されたユーザーを含まないといけないため、パラメーターからの取得はできないので、これが必要。
     */
    private function getUser($id)
    {
        return User::withTrashed()->findOrFail($id);
    }
}
