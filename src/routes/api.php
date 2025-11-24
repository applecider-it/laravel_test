<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ChatController;

// プロファイル
Route::post('/chat/callback_test', [ChatController::class, 'callback_test'])->name('chat.callback_test');
