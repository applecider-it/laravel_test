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
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\Rpc\DevelopmentRpcController;
use App\Http\Controllers\Rpc\TweetRpcController;
use App\Http\Controllers\Rpc\ChatRpcController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 認証必須

    Route::post('/push_notification', [PushNotificationController::class, 'store']);

    // プロファイル
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/toggle_push_notification', [ProfileController::class, 'toggle_push_notification'])->name('profile.toggle_push_notification');

    // Tweet
    Route::resource('tweets', TweetController::class)->only([
        'index',
        'store',
        'destroy',
    ]);
    Route::get('/tweets/index_js', [TweetController::class, 'index_js'])->name('tweets.index_js');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    // JSON-RPC
    Route::post('/rpc/development/{name}', [DevelopmentRpcController::class, 'handle']);
    Route::post('/rpc/tweet/{name}', [TweetRpcController::class, 'handle']);
    Route::post('/rpc/chat/{name}', [ChatRpcController::class, 'handle']);
});

// 開発者向けページ
Route::get('/development', [DevelopmentController::class, 'index'])->name('development.index');
Route::get('/development/backend_test', [DevelopmentController::class, 'backend_test'])->name('development.backend_test');
Route::get('/development/frontend_test', [DevelopmentController::class, 'frontend_test'])->name('development.frontend_test');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/admin_auth.php';