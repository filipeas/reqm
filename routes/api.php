<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');

    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
        Route::post('user/check', [UserController::class, 'checkUser'])->name('user.check');
        Route::put('update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::put('update/password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
        Route::delete('delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
    });
});
