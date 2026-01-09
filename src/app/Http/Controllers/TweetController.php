<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User\Tweet as UserTweet;
use App\Services\Tweet\ListService as TweetListService;
use App\Services\Tweet\FormService as TweetFormService;
use App\Services\Tweet\WebsocketService as TweetWebsocketService;
use App\Services\WebSocket\AuthService as WebSocketAuthService;
use App\Services\Channels\TweetChannel;

/**
 * ツイート管理コントローラー
 * 
 * ドキュメント
 * /documents/features/tweet.md
 */
class TweetController extends Controller
{
    public function __construct(
        private TweetListService $tweetListService,
        private TweetFormService $tweetFormService,
        private TweetWebsocketService $tweetWebsocketService,
        private WebSocketAuthService $webSocketAuthService
    ) {}

    /** 一覧ページ */
    public function index(Request $request)
    {
        return view('tweets.index', $this->indexCommon($request));
    }

    /** 追加処理 */
    public function store(Request $request)
    {
        $validation = $this->tweetFormService->newTweetValidation();
        $validated = $request->validate(
            rules: $validation['rules'],
            attributes: $validation['attributes']
        );

        $user = $request->user();

        $content = $request->input('content');

        $commit = $request->input('commit');
        $confirm = $request->input('confirm');

        Log::info('store', [$commit, $confirm]);

        if ($commit) {
            // 確定時

            $this->tweetFormService->newTweet($user, $content);

            return redirect()->back()->with('success', '投稿が作成されました')->withInput(['content' => ''] + $request->all());
        } else if ($confirm) {
            // 確認画面

            return view('tweets.confirm', [
                'data' => $validated,
            ] + $this->indexCommon($request));
        } else {
            // 戻るとき

            return redirect()->route('tweets.index')
                ->withInput($validated + $request->all());
        }
    }

    /** 一覧ページ共通処理 */
    private function indexCommon(Request $request)
    {
        $searchWord = $request->input('search_word', old('search_word'));
        $sort = $request->input('sort', old('sort', 'id'));
        $sortType = $request->input('sort_type', old('sort_type', 'desc'));
        $page = $request->input('page', old('page', 1));

        $tweets = $this->tweetListService->getTweetsForList($searchWord, $sort, $sortType);

        $tweets = $tweets->paginate(5, page: $page)->onEachSide(1);
        /*
        $tweets->appends([
            'search_word' => $searchWord,
            'sort'        => $sort,
            'sort_type'   => $sortType,
        ]);
        */
        $tweets->withQueryString();

        return compact('tweets', 'searchWord', 'sort', 'sortType', 'page');
    }

    /** 削除処理 */
    public function destroy(Request $request, UserTweet $tweet)
    {
        if ($response = $this->ownerCheck($request, $tweet)) return $response;

        $tweet->delete();

        return redirect()->route('tweets.index')->with('success', 'ツイートを削除しました');
    }

    /** 一覧ページ(JS) */
    public function index_js(Request $request)
    {
        $user = $request->user();
        $tweets = UserTweet::with('user')->latest()->take(20)->get();

        $token = $this->webSocketAuthService->createUserJwt($user, TweetChannel::getChannel());

        return view('tweets.index_js', compact('tweets', 'token', 'user'));
    }

    /** オーナーチェック */
    public function ownerCheck(Request $request, UserTweet $tweet)
    {
        if ($tweet->user_id !== $request->user()->id) {
            return redirect()->route('tweets.index')
                ->with('error', '権限がありません');
        }

        return null;
    }
}
