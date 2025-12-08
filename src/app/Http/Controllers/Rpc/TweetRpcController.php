<?php

namespace App\Http\Controllers\Rpc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

/**
 * RPC管理コントローラー
 */
class TweetRpcController extends Controller
{
    public function __construct(
    ) {}

    /** ハンドル */
    public function handle(Request $request, string $name)
    {
        $user = auth()->user();

        if ($name === 'store_tweet') {
            return response()->json(
                app(\App\Services\Tweet\FormApiService::class)->storeTweet($request)
            );
        }

        return response()->json(['error' => 'Prc name not found'], 404);
    }
}
