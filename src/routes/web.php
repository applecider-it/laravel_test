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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 認証必須

    // プロファイル
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tweet
    Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

    Route::get('/tweets/react', [TweetController::class, 'index_react'])->name('tweets.index_react');
    Route::post('/tweets/api', [TweetController::class, 'store_api'])->name('tweets.store_api');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});

require __DIR__.'/auth.php';
