<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DevelopmentController;

// 動作確認用API
Route::post('/development/chat_callback_test', [DevelopmentController::class, 'chat_callback_test'])->name('development.chat_callback_test');
