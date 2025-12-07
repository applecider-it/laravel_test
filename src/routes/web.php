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
    Route::get('/tweets/react', [TweetController::class, 'index_react'])->name('tweets.index_react');
    Route::post('/tweets/api', [TweetController::class, 'store_api'])->name('tweets.store_api');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});

// 開発者向けページ
Route::get('/development', [DevelopmentController::class, 'index'])->name('development.index');
Route::get('/development/ai_test', [DevelopmentController::class, 'ai_test'])->name('development.ai_test');
Route::get('/development/backend_test', [DevelopmentController::class, 'backend_test'])->name('development.backend_test');
Route::get('/development/frontend_test', [DevelopmentController::class, 'frontend_test'])->name('development.frontend_test');
Route::post('/development/slow_job_test', [DevelopmentController::class, 'slow_job_test'])->name('development.slow_job_test');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/admin_auth.php';