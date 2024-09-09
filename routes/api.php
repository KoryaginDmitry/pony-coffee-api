<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonusTransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::controller(UserController::class)->prefix('users')->as('user.')->group(function () {
        Route::get('', 'show')->name('show');
        Route::put('', 'update')->name('update');
        Route::put('/new-password', 'newPassword')->name('newPassword');
        Route::delete('', 'destroy')->name('destroy');
    });

    Route::controller(ReviewController::class)->as('review.')->prefix('reviews')->group(function () {
        Route::get('/user', 'userReviews')->name('user');
        Route::get('/coffeePot', 'coffeePotReviews')->name('coffeePot');
        Route::post('', 'store')->name('store');
        Route::put('/{userReview}', 'update')->name('update');
        Route::delete('/{userReview}', 'destroy')->name('delete');
    });

    Route::controller(BonusTransactionController::class)->as('transaction.')->prefix('transactions')->group(function () {
        Route::get('', 'index')->name('show');
        Route::post('/make', 'make')->name('make');
        Route::post('/use', 'use')->name('use');
    });
});

Route::middleware('guest.api')->group(function () {
    Route::controller(AuthController::class)->as('auth.')->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
    });
});
