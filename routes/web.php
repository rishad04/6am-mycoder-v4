<?php

use App\Models\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CommonThingsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SubscriptionUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//admin group
Route::prefix('admin')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('admin.login');
        Route::post('/login', 'login')->name('admin.login.submit');
        Route::get('/', 'showLoginForm')->name('admin');
        Route::get('/logout', 'logout')->name('admin.logout.get');
        Route::post('/logout', 'logout')->name('admin.logout');
    });
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::controller(DashboardController::class)->group(function () {

        Route::controller(CommonThingsController::class)->group(function () {
            Route::post('/toggle/switch/status', 'toggleSwitchStatus')->name('toggle.switch.status');
        });

        Route::get('/dashboard', 'index')->name('dashboard');

        //Tasks: 6am

        Route::resource('subscription-plans', SubscriptionPlanController::class);
        Route::resource('subscription-users', SubscriptionUserController::class);

        //Task 3
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('products',           ProductController::class);
    });
});

Route::get('/redis-test', function () {
    \Illuminate\Support\Facades\Redis::set('rishad', 'you did it!');
    return \Illuminate\Support\Facades\Redis::get('rishad');
});


Route::get('/get-latest-notification', function () {
    $message = Cache::get('latest_notification');

    $notification = Notification::where('is_broadcasted', 0)->first();

    if ($notification != '') {
        return response()->json(['message' => $notification->message]);
    }

    return response()->json(['message' => null]);
});

Route::get('/get-latest-notification-back-to-set-broadcasted', function () {
    Notification::query()->update(['is_broadcasted' => 1]);
    // dd($notification);
    return response()->json(['message' => 'resetted!']);
});
