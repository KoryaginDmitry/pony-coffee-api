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
//Возвращает адреса кофеточек и их id
Route::get('coffeePot/address', [CoffeePotController::class, 'getAddressCoffeePots']);

Route::group(
    [
        'controller' => AuthController::class,
        'middleware' => ['guest']
    ], 
    function () {
        Route::post('/login', 'login'); //Авторизация пользоватея
        Route::post('/register', 'register'); //Регистрация
    }
);

Route::group(
    [
        'middleware' => 'user'
    ],
    function () {
        Route::group(
            [
                'controller' => ProfileController::class
            ],
            function () {
                Route::get("/profile", 'getUser'); //Возвращает данные профиля
                Route::put("/profile", 'update'); //Редактирование профиля
                Route::put("/profile/password", 'newPassword'); //Обновление пароля
            }
        );

        Route::get('/user/bonuses', [BonusController::class, 'getInfoBonuses']);

        Route::group(
            [
                'controller' => NotificationController::class
            ], 
            function () {
                //Возвращает уведомления для пользователя
                Route::get("/notification", 'getUserNotifications');
                //Убирает сообщение для пользователя(делает его прочитанным)
                Route::put("/notification/{id}", "read");
                //Возвращает кол-во уведомлений
                Route::get("notification/count", "getCount");
            }
        );

        Route::group(
            [
                'controller' => FeedbackController::class
            ], 
            function () {
                // Возвращает все все обращения пользователя в обратную связь,
                // если делать запрос с профился админа, то просто вернет все 
                // обращаения и сообщеня
                Route::get("feedback", 'getFeedback');
                // Создание обращения в обратную связь
                Route::post('feedback', 'create');
                // Создание сообщения для определенного обращение, id обращения 
                // передается в адресной строке
                Route::post('feedback/{id}', 'createMessage'); 
            }
        );
    }
);

Route::group(
    [
        'controller' => BonusController::class,
        'middleware' => 'barista'
    ], 
    function () {
        Route::get('search', 'search'); //Поиск гостя по id или номеру телефона
        Route::post('bonus/{id}', 'create'); //Создание бонуса для гостя
        Route::put('bonus/{id}', 'wrote'); //Списание бонусов у гостя
    }
);

Route::group(
    [
        'middleware' => 'admin'
    ],
    function () {
        Route::group(
            [
                'controller' => StatisticController::class
            ],
            function () {
                //Статистика барист
                Route::get('/statistic', 'barista');
                //статистика гостей
                Route::get('statistic/users', 'user');
            }
        );

        Route::group(
            [
                'controller' => FeedbackController::class
            ],
            function () {
                //Возвращает все feedback
                Route::get('admin/feedback/{id?}', 'getFeedback');
                //создает сообщения для обратной связи
                Route::post('admin/feedback/{id}', 'createMessage');
            }
        );

        Route::group(
            [
                'controller' => NotificationController::class
            ],
            function () {
                //Возвращает все уведомления
                Route::get('admin/notification', 'getNotificationForAdmin');
                //Создает уведомление
                Route::post('admin/notification', 'createNotification');
            }
        );

        Route::group(
            [
                'controller' => CoffeePotController::class
            ],
            function () {
                //Возвращает все кофеточки
                Route::get('admin/coffeePot', 'getCoffeePots');
                //Содает кофеточку
                Route::post('admin/coffeePot', 'create');
                //обновляет кофеточку
                Route::put('admin/coffeePot/{id}', 'update');
                //удаляет кофеточку
                Route::delete('admin/coffeePot/{id}', 'delete');
            }
        );

        Route::group(
            [
                'controller' => BaristaProfileController::class
            ],
            function () {
                //возвращает всех барист
                Route::get('barista', 'get');
                //создает баристу
                Route::post('barista', 'create');
                //редактирование баристы
                Route::put('barista/{id}', 'update');
                //удаление баристы
                Route::delete('barista/{id}', 'delete');
            }
        );
    }
);