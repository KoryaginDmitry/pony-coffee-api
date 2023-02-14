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

Route::middleware(['guest', 'reCaptcha'])->group(
    function () {
        Route::controller(AuthController::class)->group(
            function () {
                //Login with phone and password
                Route::post('/login', 'login')
                    ->withoutMiddleware('reCaptcha');
                //Login with phone and code
                Route::post('login/phone', 'phoneLogin')
                    ->middleware('codeVerification');
                //Login with email and code
                Route::post('/email/login', 'emailLogin')
                    ->middleware('codeVerification:email');
                Route::post('/register', 'register')
                    ->middleware('codeVerification');
            }
        );

        Route::controller(SendCodeController::class)->group(
            function () {
                //Call to get a login code by phone
                Route::post('/login/call', 'call')->name('sendLoginCode');
                //receive code by email
                Route::post('login/email/code', 'sendEmailCode');
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

Route::middleware('role:user,admin')->group(
    function () {
        Route::controller(UserController::class)->group(
            function () {
                //gets a profile auth user
                Route::get("/profile", 'authUser');
                Route::put('profile/name', 'updateName');
                Route::put('profile/phone', 'updatePhone')
                    ->middleware(['reCaptcha', 'codeVerification']);

                Route::put('profile/email', 'updateEmail')
                    ->middleware('codeVerification:email');

                Route::put("/profile/password", 'newPassword');
            }
        );
        //sends verification code to email
        Route::post('/mail/verification/code', [SendCodeController::class, 'sendEmailCode'])
            //->middleware('reCaptcha')
            ->name('verificationEmail');
    }
);

Route::middleware('role:user')->group(
    function () {
        //get data about authorized user's bonuses
        Route::get('/user/bonuses', [BonusController::class, 'getInfoBonuses']);

        Route::controller(NotificationController::class)->group(
            function () {
                //get notifications for auth user
                Route::get("/notification", 'getUserNotifications');
                //read notification
                Route::put("/notification/{notification}", "read");
                //get count notifications for auth user
                Route::get("notification/count", "getCount");
            }
        );

        Route::controller(FeedbackController::class)->group(
            function () {
                //get user feedbacks
                Route::get("/feedback", 'getFeedbacks');
                //get one feedback
                Route::get("/feedback/{feedback}", 'getFeedback');
                //user requests for feedback on the coffee shop
                Route::get("/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot');
                //create feedback and message
                Route::post('/feedback', 'create');
                //create message for feedback
                Route::post('/feedback/{feedback}', 'createMessage');
            }
        );
    }
);

Route::middleware('role:barista')->group(
    function () {
        Route::controller(BonusController::class)->group(
            function () {
                //create bonuses for user
                Route::post('bonus/{user}', 'create');
                //write off bonuses from the user
                Route::put('bonus/{user}', 'wrote');
            }
        );

        Route::controller(UserController::class)->group(
            function () {
                //get all users
                Route::get('/users', 'users');
                //create user
                Route::post('/user/create', 'create');
            }
        );
    }
);

Route::middleware('role:admin')->group(
    function () {
        Route::controller(StatisticController::class)->group(
            function () {
                //get data for statistic baristas
                Route::get('/statistic', 'barista');
                //get data for statistic users
                Route::get('statistic/users', 'user');
                //get data for user statistics for a week or a month
                Route::get('statistic/users/{interval}', 'userTimeInterval')
                    ->where('interval', '7|31');
            }
        );

        Route::controller(FeedbackController::class)->group(
            function () {
                Route::get('admin/shorts/feedbacks', 'shortsFeedbacks');
                //get all users and last message
                Route::get("admin/feedbacks", 'getFeedbacks');
                //get all feedbacks of user
                Route::get('admin/feedbacks/user/{user}', 'getUserFeedbacks');
                //get one feedback
                Route::get("admin/feedback/{feedback}", 'getFeedback');
                //get all feedback on the coffee shop
                Route::get("admin/feedback/coffeePot/{coffeePot}", 'getFeedbackCoffeePot');
                //create message for feedback
                Route::post('admin/feedback/{feedback}', 'createMessage');
            }
        );

        Route::controller(NotificationController::class)->group(
            function () {
                //get all notifications
                Route::get('admin/notification', 'getNotificationForAdmin');
                //create notification
                Route::post('admin/notification', 'createNotification');
            }
        );

        Route::controller(CoffeePotController::class)->group(
            function () {
                //get one coffeePot
                Route::get('admin/coffeePot/{coffeePot}', 'getCoffeePot');
                //create coffeePot
                Route::post('admin/coffeePot', 'create');
                //update coffeePot
                Route::put('admin/coffeePot/{coffeePot}', 'update');
                //delete coffeePot
                Route::delete('admin/coffeePot/{coffeePot}', 'delete');
            }
        );

        Route::controller(BaristaProfileController::class)->group(
            function () {
                //get all baristas user
                Route::get('barista', 'getAll');
                //get one barista user
                Route::get('barista/{barista}', 'getBarista');
                //create barista user
                Route::post('barista', 'create');
                //update barista user
                Route::put('barista/{barista}', 'update');
                //delete barista user
                Route::delete('barista/{barista}', 'delete');
            }
        );
    }
);

Route::controller(SiteDataController::class)->group(
    function () {
        //get links for header site
        Route::get("/header", 'header');
        //get lifetime bonus
        Route::get('/bonus/lifetime', 'bonusLifetime');
    }
);

//get all coffeePot
Route::get('coffeePot', [CoffeePotController::class, 'getCoffeePots']);

//sends verification code to phone
Route::post('/call', [SendCodeController::class, 'call'])
    ->middleware('reCaptcha');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:api');
