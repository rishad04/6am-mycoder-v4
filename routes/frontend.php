<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Admin\SubscriptionUserController;
use App\Http\Controllers\Frontend\FrontendLandingPageController;
use App\Http\Controllers\Frontend\FrontendUserSubscriptionController;

// routes/frontend.php

Route::prefix('frontend')->name('frontend.')->group(function () {

    // Landing and Auth Pages
    Route::get('/home', [FrontendLandingPageController::class, 'index'])->name('landing.index');
    Route::get('/login', [FrontendLandingPageController::class, 'loginFormShow'])->name('login');
    Route::get('/register', [FrontendLandingPageController::class, 'registerFormShow'])->name('register');



    // Auth actions
    Route::middleware('guest')->group(function () {
        Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit');
        Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout');

        // Task Management
        Route::get('/my-tasks', [FrontendLandingPageController::class, 'myTasks'])->name('my-tasks.index');
        Route::get('/my-task/{id}', [FrontendLandingPageController::class, 'myTaskDetails'])->name('my-tasks.details');
        Route::post('/my-tasks', [FrontendLandingPageController::class, 'myTasksStore'])->name('my-tasks.store');
    });

    // Products - Cached & Non-Cached
    Route::get('/product-showcase/{slug?}', [FrontendLandingPageController::class, 'products'])->name('product-showcase.index');
    Route::get('/product-details/{slug}', [FrontendLandingPageController::class, 'productDetails'])->name('product.details');

    Route::get('/product-showcase-cached/{slug?}', [FrontendLandingPageController::class, 'productsCasched'])->name('product-showcase-cached.index');
    Route::get('/product-details-cached/{slug}', [FrontendLandingPageController::class, 'productDetailsCached'])->name('product.details.cached');
});



// Task 1 Frontend Subscription, Cancel Subscription and Subscription Details Vide Routes
Route::group(['Middleware' => 'auth:sanctum'], function () {

    Route::post('/subscribe', [FrontendUserSubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/subscription/view/{id}', [FrontendUserSubscriptionController::class, 'subscriptionShowFrontend']);
    Route::post('/subscription-cancel', [FrontendUserSubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel');
});

Route::get('/notifications/fetch', [FrontendLandingPageController::class, 'fetch'])->name('fetch.notifications');
