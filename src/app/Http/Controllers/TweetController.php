<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetController extends Controller
{
    /** 一覧ページ */
    public function index()
    {
        $tweets = Tweet::with('user')->latest()->get();
        return view('tweets.index', compact('tweets'));
    }

    /** 追加処理 */
    public function store(Request $request)
    {
        $request->validate(
            rules: [
                'content' => 'required|max:280'
            ],
            attributes: [
                'content' => '投稿内容'
            ]
        );

        $request->user()->tweets()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
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
        $request->validate(
            rules: [
                'content' => 'required|max:280'
            ],
            attributes: [
                'content' => '投稿内容'
            ]
        );
    
        $tweet = $request->user()->tweets()->create([
            'content' => $request->content,
        ]);
    
        return response()->json(
            $tweet->load('user')
        );
    }
}
