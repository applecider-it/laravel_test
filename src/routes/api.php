<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\ChatController;

// プロファイル
Route::post('/chat/callback_test', [ChatController::class, 'callback_test'])->name('chat.callback_test');
