<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaristaProfileController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\CoffeePotController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PhoneController;
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
Route::post('sendMail', [MailController::class, 'sendCode']);

Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::get("/header", [HomeController::class, 'get']);

//Возвращает адреса кофеточек и их id
Route::get('coffeePot/address', [CoffeePotController::class, 'getAddressCoffeePots']);

Route::post('/sendCode', [PhoneController::class, 'sendCode'])
    ->middleware('api_session');

Route::group(
    [
        'middleware' => 'guest'
    ],
    function () {
        Route::group(
            [
                'controller' => AuthController::class,
            ],
            function () {
                Route::post('/login', 'login'); //Авторизация пользователя
                Route::post('login/phone', 'phonelogin')->middleware('api_session');
                Route::post('/register', 'register')->middleware('api_session'); //Регистрация
            }
        );
    }
);


Route::group(
    [
        'middleware' => 'can:isUser'
    ],
    function () {
        Route::group(
            [
                'controller' => ProfileController::class
            ],
            function () {
                Route::get("/profile", 'getUser'); //Возвращает данные профиля
                Route::put('profile/name', 'updateName');
                Route::put('profile/phone', 'updatePhone');
                Route::put('profile/email', 'updateEmail');
                Route::put("/profile/password", 'newPassword'); //Обновление пароля
            }
        );

        Route::post('/login/sendCode', [PhoneController::class, 'sendCode'])
            ->name('sendloginCode')
            ->middleware('api_session');

        Route::get('/user/bonuses', [BonusController::class, 'getInfoBonuses']);

        Route::group(
            [
                'controller' => NotificationController::class
            ], 
            function () {
                //Возвращает уведомления для пользователя
                Route::get("/notification", 'getUserNotifications');
                //Убирает сообщение для пользователя(делает его прочитанным)
                Route::put("/notification/{notification}", "read");
                //Возвращает кол-во уведомлений
                Route::get("notification/count", "getCount");
            }
        );

        Route::group(
            [
                'controller' => FeedbackController::class
            ],
            function () {
                // Возвращает все обращения пользователя
                Route::get("/feedback", 'getFeedbacks');
                // Возвращает определенное обращение
                Route::get("/feedback/{feedback}", 'getFeedback');
                //Врзвращает обращения по кофейне
                Route::get("/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot');
                // Создание обращения
                Route::post('/feedback', 'create');
                // Создание сообщения для определенного обращение
                Route::post('/feedback/{feedback}', 'createMessage');
            }
        );
    }
);

Route::group(
    [
        'controller' => BonusController::class,
        'middleware' => 'can:isBarista'
    ], 
    function () {
        //Поиск гостя по id или номеру телефона
        Route::get('/users', 'getUsers');
        //Создание бонуса для гостя
        Route::post('bonus/{user}', 'create');
        //Списание бонусов у гостя
        Route::put('bonus/{user}', 'wrote');
    }
);

Route::group(
    [
    'middleware' => 'can:isAdmin'
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
                // Возвращает все обращения
                Route::get("admin/feedback", 'getFeedbacks');
                // Возвращает определенное обращение
                Route::get("admin/feedback/{feedback}", 'getFeedback');
                //Врзвращает обращения по кофейне
                Route::get("admin/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot');
                // Создание сообщения для определенного обращение
                Route::post('feedback/{feedback}', 'createMessage');
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
                //Возвращает данные по одной кофейне
                Route::get('admin/coffeePot/{coffeePot}', 'getCoffeePot');
                //Содает кофеточку
                Route::post('admin/coffeePot', 'create');
                //обновляет кофеточку
                Route::put('admin/coffeePot/{coffeePot}', 'update');
                //удаляет кофеточку
                Route::delete('admin/coffeePot/{coffeePot}', 'delete');
            }
        );

        Route::group(
            [
                'controller' => BaristaProfileController::class
            ],
            function () {
                //возвращает всех барист
                Route::get('barista', 'get');
                //возвращает определенного баристу
                Route::get('barista/{barista}', 'getBarista');
                //создает баристу
                Route::post('barista', 'create');
                //редактирование баристы
                Route::put('barista/{barista}', 'update');
                //удаление баристы
                Route::delete('barista/{barista}', 'delete');
            }
        );
    }
);