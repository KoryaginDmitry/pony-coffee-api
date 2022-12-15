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
    Route::post('/login', 'login'); //Авторизация пользоватея
    Route::post('/register', 'register'); //Регистрация
});

Route::middleware('user')->group(function(){
    Route::controller(ProfileController::class)->group(function(){
        Route::get("/profile", 'getUser'); //Возвращает данные профиля
        Route::post("/profile/update", 'update'); //Редактирование профиля
    });

    Route::controller(BonusController::class)->group(function(){
        Route::get('/user/bonuses', 'getInfoBonuses'); //Возврашает кол-во активных пользователей и сгорание бонусов
    });

    Route::controller(NotificationController::class)->group(function(){
        Route::get("/notification", 'getUserNotification'); //Возвращает уведомления для пользователя
        Route::post("/notification/read/{id}", "read"); //Убирает сообщение для пользователя(делает его прочитанным)
        Route::get("notification/count", "getCount"); //Возвращает кол-во уведомлений
    });

    Route::controller(FeedbackController::class)->group(function(){
        Route::get("feedback", 'getFeedback'); //Возвращает все все обращения пользователя в обратную связь, если делать запрос с профился админа, то просто вернет все обращаения и сообщеня
        Route::post('feedback/create', 'create'); //Создание обращения в обратную связь
        Route::post('feedback/{id}/createMessage', 'createMessage'); //Создание сообщения для определенного обращение, id обращения передается в адресной строке
    });
});