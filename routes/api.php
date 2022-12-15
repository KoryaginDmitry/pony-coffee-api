<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('guest:api')->controller(AuthController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::middleware('user')->group(function(){
    Route::controller(ProfileController::class)->group(function(){
        Route::get("/profile", 'getUser');
        Route::post("/profile/update", 'update');
    });

    Route::controller(BonusController::class)->group(function(){
        Route::get('/user/bonuses', 'getInfoBonuses');
    });

    Route::controller(NotificationController::class)->group(function(){
        Route::get("/notification", 'getUserNotification');
        Route::post("/notification/read/{id}", "read");
        Route::get("notification/count", "getCount");
    });

    Route::controller(FeedbackController::class)->group(function(){
        Route::get("feedback", 'getFeedback');
        Route::post('feedback/create', 'create');
        Route::post('feedback/{id}/createMessage', 'createMessage');
    });
});