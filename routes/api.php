<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SendCodeController;
use App\Http\Controllers\BaristaProfileController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\CoffeePotController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SiteDataController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ResetPasswordController;
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

Route::middleware(['role:guest', 'reCaptcha'])->group(
    function () {
        Route::controller(AuthController::class)->group(
            function () {
                //Login with phone and password
                Route::post('/login', 'login')
                    ->withoutMiddleware('reCaptcha')
                    ->name('login');

                //Login with phone and code
                Route::post('login/phone', 'phoneLogin')
                    ->middleware('codeVerification')
                    ->name('login.phone');

                //Login with email and code
                Route::post('/email/login', 'emailLogin')
                    ->middleware('codeVerification:email')
                    ->name('login.email');

                Route::post('/register', 'register')
                    ->middleware('codeVerification')
                    ->name('register');
            }
        );

        Route::controller(SendCodeController::class)->group(
            function () {
                //Call to get a login code by phone
                Route::post('/login/call', 'call')
                    ->name('sendLoginCode');

                //receive code by email
                Route::post('login/email/code', 'sendEmailCode')
                    ->name('emailCode.guest');
            }
        );

        Route::controller(ResetPasswordController::class)->group(
            function () {
                //get a password reset link
                Route::post('forgot-password', 'forgotPassword');
                Route::post('reset-password', 'resetPassword');
            }
        );
    }
);

Route::middleware('role:user')->group(
    function () {
        //get data about authorized user's bonuses
        Route::get('/user/bonuses', [BonusController::class, 'getInfoBonuses'])
            ->name('bonus.information');

        Route::controller(NotificationController::class)->group(
            function () {
                //get notifications for auth user
                Route::get("/notification", 'getUserNotifications')
                    ->name('notification.getForUser');
                //read notification
                Route::put("/notification/{notification}", "read")
                    ->name('notification.read');
                //get count notifications for auth user
                Route::get("notification/count", "getCount")
                    ->name('notification.getCount');
            }
        );

        Route::controller(FeedbackController::class)->group(
            function () {
                //get user feedbacks
                Route::get("/feedback", 'getFeedbacks')
                    ->name('feedbacks.getForUser');
                //get one feedback
                Route::get("/feedback/{feedback}", 'getFeedback')
                    ->name('feedback.getForUser');
                //user requests for feedback on the coffee shop
                Route::get("/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot')
                    ->name('user.feedback.coffeePot');
                //create feedback and message
                Route::post('/feedback', 'create')
                    ->name('feedback.create');
                //create message for feedback
                Route::post('/feedback/{feedback}', 'createMessage')
                    ->name('feedback.createMessage');
            }
        );
    }
);

Route::middleware('role:barista')->group(
    function () {
        Route::controller(BonusController::class)->group(
            function () {
                //create bonuses for user
                Route::post('bonus/{user}', 'create')->name('bonus.create');
                //write off bonuses from the user
                Route::put('bonus/{user}', 'wrote')->name('bonus.wrote');
            }
        );

        Route::controller(UserController::class)->group(
            function () {
                //get all users
                Route::get('/users', 'users')->name('barista.getUsers');
                //create user
                Route::post('/user/create', 'userCreate')
                    ->middleware('codeVerification')
                    ->name('barista.user.create');
            }
        );
    }
);

Route::middleware('role:admin')->group(
    function () {
        Route::controller(StatisticController::class)->group(
            function () {
                //get data for statistic baristas
                Route::get('/statistic', 'barista')->name('statistic.barista');
                //get data for statistic users
                Route::get('statistic/users', 'user')->name('statistic.user');
                //get data for user statistics for a week or a month
                Route::get('statistic/users/{interval}', 'userTimeInterval')
                    ->where('interval', '7|31')
                    ->name('statistic.interval');
            }
        );

        Route::controller(FeedbackController::class)->group(
            function () {
                //get short info
                Route::get('admin/feedback/short/{filter}', 'getShortFeedback')
                    ->whereIn('filter', ['users', 'coffeePots'])
                    ->name('feedback.short');

                //get all feedbacks
                Route::get("admin/feedbacks", 'getFeedbacks')
                    ->name('feedback.all');
                //get all feedback on the user
                Route::get('admin/feedback/user/{user}', 'getFeedbacksUser')
                    ->name('feedback.user');
                //get all feedback on the coffee shop
                Route::get("admin/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot')
                    ->name('feedback.coffeePot');

                //get one feedback
                Route::get("admin/feedback/{feedback}", 'getFeedback')
                    ->name('feedback.one');

                //create message for feedback
                Route::post('admin/feedback/{feedback}', 'createMessage')
                    ->name('feedback.create.message');
            }
        );

        Route::controller(NotificationController::class)->group(
            function () {
                //get all notifications
                Route::get('admin/notification', 'getNotificationForAdmin')
                    ->name('notification.getForAdmin');
                //create notification
                Route::post('admin/notification', 'createNotification')
                    ->name('notification.create');
            }
        );

        Route::controller(CoffeePotController::class)->group(
            function () {
                //get one coffeePot
                Route::get('admin/coffeePot/{coffeePot}', 'getCoffeePot')
                    ->name('coffeePot.getOne');
                //create coffeePot
                Route::post('admin/coffeePot', 'create')->name('coffeePot.create');
                //update coffeePot
                Route::put('admin/coffeePot/{coffeePot}', 'update')->name('coffeePot.update');
                //delete coffeePot
                Route::delete('admin/coffeePot/{coffeePot}', 'delete')->name('coffeePot.delete');
            }
        );

        Route::controller(BaristaProfileController::class)->group(
            function () {
                //get all baristas user
                Route::get('barista', 'getAll')->name('barista.getAll');
                //get one barista user
                Route::get('barista/{barista}', 'getBarista')->name('barista.getOne');
                //create barista user
                Route::post('barista', 'create')->name('barista.create');
                //update barista user
                Route::put('barista/{barista}', 'update')->name('barista.update');
                //delete barista user
                Route::delete('barista/{barista}', 'delete')->name('barista.delete');
            }
        );
    }
);

Route::controller(SiteDataController::class)->group(
    function () {
        //get links for header site
        Route::get("/header", 'header')->name('SiteData.header');
        //get lifetime bonus
        Route::get('/bonus/config', 'getBonusConfig')->name('SiteData.bonus');
        //get channels for user
        Route::get('/channels', 'getChannels')->name('SiteData.channels');
    }
);

//get all coffeePot
Route::get('coffeePot', [CoffeePotController::class, 'getCoffeePots'])
    ->name('coffeePot.getAll');

//sends verification code to phone
Route::post('/call', [SendCodeController::class, 'call'])
    ->middleware('reCaptcha')
    ->name('call');

Route::middleware('role:admin,barista,user')->group(
    function () {
        Route::controller(UserController::class)->group(
            function () {
                //gets a profile auth user
                Route::get("/profile", 'authUser')
                    ->name('profile');

                Route::put('profile/name', 'updateName')
                    ->name('profile.name');

                Route::put('profile/phone', 'updatePhone')
                    ->middleware(['reCaptcha', 'codeVerification'])
                    ->name('profile.phone');

                Route::put('profile/email', 'updateEmail')
                    ->middleware('codeVerification:email')
                    ->name('profile.email');

                Route::put("/profile/password", 'newPassword')
                    ->name('profile.password');
            }
        );
        //sends verification code to email
        Route::post('/mail/verification/code', [SendCodeController::class, 'sendEmailCode'])
            ->middleware('reCaptcha')
            ->name('verificationEmail');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);
