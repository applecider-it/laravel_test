<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User\Tweet;
use App\Services\Tweet\ListService;
use App\Services\Tweet\EditService;

/**
 * ツイート管理コントローラー
 * 
 * ドキュメント
 * /documents/features/tweet.md
 */
class TweetController extends Controller
{
    public function __construct(
        private ListService $listService,
        private EditService $editService,
    ) {}

    /** 一覧ページ */
    public function index(Request $request)
    {
        $searchWord = $request->input('search_word');
        $page = $request->input('page', 1);

        $tweets = $this->listService->getTweets($searchWord);

        $tweets = $tweets->paginate(5, page: $page)->onEachSide(1);
        $tweets->withQueryString();

        return view('tweet.index', compact('tweets', 'searchWord', 'page'));
    }

    /** 新規作成 */
    public function create()
    {
        $tweet = new Tweet;
        return view('tweet.create', compact('tweet'));
    }

    /** 追加処理 */
    public function store(Request $request)
    {
        $tweet = new Tweet;
        $validated = $request->validate(
            rules: [
                'content' => $tweet->validationContent(),
            ],
            attributes: [
                'content' => __('app.models.user/tweet.columns.content')
            ]
        );

        $user = $request->user();

        $content = $request->input('content');

        $commit = $request->input('commit');
        $confirm = $request->input('confirm');

        Log::info('store', [$commit, $confirm]);

        if ($commit) {
            // 確定時

            $this->editService->newTweet($user, $content);

            return redirect()->back()->with('success', '投稿が作成されました')->withInput(['content' => ''] + $request->all());
        } else if ($confirm) {
            // 確認画面

            return view('tweet.confirm', [
                'data' => $validated,
            ]);
        } else {
            // 戻るとき

            return redirect()->route('tweet.create')
                ->withInput($validated);
        }
    }
}
