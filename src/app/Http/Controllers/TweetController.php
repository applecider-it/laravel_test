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
        $request->validate([
            'content' => 'required|max:280',
        ]);

        $request->user()->tweets()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}
