<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $token = JWT::encode([
            'sub' => $user->id,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 12, // 12時間
        ], env('WS_JWT_SECRET'), 'HS256');

        return view('chat.index', compact('token'));
    }
}
