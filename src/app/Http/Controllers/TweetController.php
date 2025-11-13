<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

use App\Services\Tweet\ListService as TweetListService;
use App\Services\Tweet\FormService as TweetFormService;

class TweetController extends Controller
{
    public function __construct(
        private TweetListService $tweetListService,
        private TweetFormService $tweetFormService
    ) {}

    /** 一覧ページ */
    public function index(Request $request)
    {
        $searchWord = $request->input('search_word');
        $sort       = $request->input('sort', 'id');
        $sortType   = $request->input('sort_type', 'desc');

        $tweets = $this->tweetListService->getTweetsForList($searchWord, $sort, $sortType);

        $tweets = $tweets->paginate(3);
        /*
        $tweets->appends([
            'search_word' => $searchWord,
            'sort'        => $sort,
            'sort_type'   => $sortType,
        ]);
        */
        $tweets->withQueryString();

        return view('tweets.index', compact('tweets', 'searchWord', 'sort', 'sortType'));
    }

    /** 追加処理 */
    public function store(Request $request)
    {
        $tweet = new Tweet();
        $request->validate(
            rules: [
                'content' => $tweet->validation_content(),
            ],
            attributes: [
                'content' => __('models.tweet.columns.content')
            ]
        );

        $user = $request->user();
        $content = $request->input('content');

        $this->tweetFormService->newTweet($user, $content);

        return redirect()->back()->with('success', '投稿が作成されました');
    }

    /** 一覧ページ(React) */
    public function index_react()
    {
        $tweets = Tweet::with('user')->latest()->get();
        return view('tweets.index_react', compact('tweets'));
    }

    /** 追加処理API */
    public function store_api(Request $request)
    {
        $tweet = new Tweet();
        $request->validate(
            rules: [
                'content' => $tweet->validation_content(),
            ],
            attributes: [
                'content' => __('models.tweet.columns.content')
            ]
        );

        $user = $request->user();
        $content = $request->input('content');

        $tweet = $this->tweetFormService->newTweet($user, $content);

        return response()->json(
            $tweet->load('user')
        );
    }
}
