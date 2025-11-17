<?php

/**
 * Webのルート
 * 
 * 認証系はauth.phpにある
 */

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/push_notification', [TestController::class, 'push_notification']);

Route::middleware('auth')->group(function () {
    // 認証必須

    // プロファイル
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tweet
    Route::resource('tweets', TweetController::class)->only([
        'index',
        'store'
    ]);
    Route::get('/tweets/react', [TweetController::class, 'index_react'])->name('tweets.index_react');
    Route::post('/tweets/api', [TweetController::class, 'store_api'])->name('tweets.store_api');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});

// Test
Route::get('/test', [TestController::class, 'index'])->name('test.index');
Route::get('/test/ai_test', [TestController::class, 'ai_test'])->name('test.ai_test');
Route::get('/test/websocket_test', [TestController::class, 'websocket_test'])->name('test.websocket_test');
Route::get('/test/livewire_test', [TestController::class, 'livewire_test'])->name('test.livewire_test');
Route::get('/test/backend_test', [TestController::class, 'backend_test'])->name('test.backend_test');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/admin_auth.php';