<?php
/**
 * 管理画面（手作り）のルート
 */

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;

Route::prefix(config('myapp.admin_uri_prefix'))->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::post('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
});
