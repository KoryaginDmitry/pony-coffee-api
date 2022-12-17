<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaristaProfileController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\CoffeePotController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticController;
use App\Models\CoffeePot;
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
Route::get("/header", [HomeController::class, 'get']);

Route::middleware('guest')->controller(AuthController::class)->group(function(){
    Route::post('/login', 'login'); //Авторизация пользоватея
    Route::post('/register', 'register'); //Регистрация
});

Route::middleware('user')->group(function(){
    Route::controller(ProfileController::class)->group(function(){
        Route::get("/profile", 'getUser'); //Возвращает данные профиля
        Route::put("/profile", 'update'); //Редактирование профиля
    });

    Route::controller(BonusController::class)->group(function(){
        Route::get('/user/bonuses', 'getInfoBonuses'); //Возврашает кол-во активных пользователей и сгорание бонусов
    });

    Route::controller(NotificationController::class)->group(function(){
        Route::get("/notification", 'getUserNotification'); //Возвращает уведомления для пользователя
        Route::put("/notification/{id}", "read"); //Убирает сообщение для пользователя(делает его прочитанным)
        Route::get("notification/count", "getCount"); //Возвращает кол-во уведомлений
    });

    Route::controller(FeedbackController::class)->group(function(){
        Route::get("feedback", 'getFeedback'); //Возвращает все все обращения пользователя в обратную связь, если делать запрос с профился админа, то просто вернет все обращаения и сообщеня
        Route::post('feedback', 'create'); //Создание обращения в обратную связь
        Route::post('feedback/{id}', 'createMessage'); //Создание сообщения для определенного обращение, id обращения передается в адресной строке
    });
});

Route::controller(BonusController::class)->group(function(){
    Route::get('search', 'search'); //Поиск гостя по id или номеру телефона
    Route::post('bonus/{id}', 'create'); //Создание бонуса для гостя
    Route::put('bonus/{id}', 'wrote'); //Списание бонусов у гостя
})->middleware('barista');

Route::middleware('admin')->group(function(){
    Route::controller(StatisticController::class)->group(function(){
        Route::get('/statistic', 'barista'); //Статистика барист
        Route::get('statistic/users', 'user'); //статистика гостей
    });
    
    Route::controller(CoffeePotController::class)->group(function(){
        Route::get('/coffeePot/address', 'getAddressCoffeePots'); //Возвращает адреса кофеточек и их id
    });

    Route::controller(FeedbackController::class)->group(function(){
        Route::get('admin/feedback/{id?}', 'getFeedback'); //Возвращает все feedback
        Route::post('admin/feedback/{id}', 'createMessage'); //создает сообщения для обратной связи
    });

    Route::controller(NotificationController::class)->group(function(){
        Route::get('admin/notification', 'getNotificationForAdmin'); //Возвращает все уведомления
        Route::post('admin/notification', 'createNotification'); //Создает уведомление
    });

    Route::controller(CoffeePotController::class)->group(function(){
        Route::get('admin/coffeePot', 'getCoffeePots'); //Возвращает все кофеточки
        Route::post('admin/coffeePot', 'create'); //Содает кофеточку
        Route::put('admin/coffeePot/{id}', 'update'); //обновляет кофеточку
        Route::delete('admin/coffeePot/{id}', 'delete'); //удаляет кофеточку
    });

    Route::controller(BaristaProfileController::class)->group(function(){
        Route::get('barista', 'get'); //возвращает всех барист
        Route::post('barista', 'create'); //создает баристу
        Route::put('barista/{id}', 'update'); //редактирование баристы
        Route::delete('barista/{id}', 'delete'); //удаление баристы
    });
});