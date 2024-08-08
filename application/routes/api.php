<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//Route::post('/logout', 'App\Http\Controllers\Auth\AuthenticationController@logout')->middleware('auth');
//Route::post('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordLinkController@store');
//Route::post('/reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@reset');
//Route::get('/reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@redirectToResetForm');
//Route::get('/forgot-password/{token}', 'App\Http\Controllers\Auth\ForgotPasswordController@showResetForm');
//Route::get('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordLinkController@create');

/**
 * login and logout routes
 */
Route::post('/login', 'App\Http\Controllers\Auth\AuthenticationController@login')->name('login');
Route::post('/logout', 'App\Http\Controllers\Auth\AuthenticationController@logout')->middleware('auth.custom');

/**
 * burger list route
 */
Route::get('/burgers', 'App\Http\Controllers\BurgerController@index');
Route::get('/burgers/{id}', 'App\Http\Controllers\BurgerController@show');


Route::middleware('api')->group(function () {
    /**
     * login and register routes
     */
    Route::post('/register', 'App\Http\Controllers\Auth\AuthenticationController@register');
//    Route::post('/login', 'App\Http\Controllers\Auth\AuthenticationController@login');

    // auth routes
    Route::middleware('auth.custom')->group(function (){
//        Route::post('/logout', 'App\Http\Controllers\Auth\AuthenticationController@logout');
        /**
         * order routes
         */
        Route::get('/orders', 'App\Http\Controllers\OrderController@index');
        Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show');
        Route::post('/orders', 'App\Http\Controllers\OrderController@store');
        Route::put('/orders/{id}', 'App\Http\Controllers\OrderController@update');
        /**
         * orderItem routes
         */
        Route::get('/orderItems', 'App\Http\Controllers\OrderItemController@index');
        Route::get('/orderItems/{orderItem}', 'App\Http\Controllers\OrderItemController@show');
        Route::post('/orderItems', 'App\Http\Controllers\OrderItemController@store');
        Route::put('/orderItems/{orderItem}', 'App\Http\Controllers\OrderItemController@update');
        Route::delete('/orderItems/{orderItem}', 'App\Http\Controllers\OrderItemController@destroy');
        /**
         * burger routes
         */

        Route::middleware('checkRole:manager')->group(function (){
            /**
             * payment routes
             */
            Route::get('/payments', 'App\Http\Controllers\PaymentController@index');
            Route::get('/payments/{id}', 'App\Http\Controllers\PaymentController@show');
            Route::post('/payments', 'App\Http\Controllers\PaymentController@store');
            Route::put('/payments/{id}', 'App\Http\Controllers\PaymentController@update');
            Route::delete('/payments/{id}', 'App\Http\Controllers\PaymentController@destroy');

            // admin routes
            Route::middleware('checkRole:admin')->group(function (){
                // burger routes
                Route::post('/burgers', 'App\Http\Controllers\BurgerController@store');
                Route::put('/burgers/{id}', 'App\Http\Controllers\BurgerController@update');
                Route::delete('/burgers/{id}', 'App\Http\Controllers\BurgerController@destroy');
                // order routes
                Route::delete('/orders/{id}', 'App\Http\Controllers\OrderController@destroy');
                /**
                 * user routes
                 */
                Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index');
                Route::get('/users', 'App\Http\Controllers\Admin\UserController@index');
                Route::get('/users/{id}', 'App\Http\Controllers\Admin\UserController@show');
                Route::post('/users', 'App\Http\Controllers\Admin\UserController@store');
                Route::put('/users/{id}', 'App\Http\Controllers\Admin\UserController@update');
                Route::delete('/users/{id}', 'App\Http\Controllers\Admin\UserController@destroy');
            });
        });
    });
});
