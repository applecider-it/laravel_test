<?php
/**
 * 管理画面（手作り）のルート
 */

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;

Route::prefix('admin_HandMade')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('users', UserController::class);
});
