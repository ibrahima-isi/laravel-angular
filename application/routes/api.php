<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@store');
//Route::post('/login', 'App\Http\Controllers\Auth\LoginController@store');
//Route::post('/logout', 'App\Http\Controllers\Auth\LogoutController@destroy')->middleware('auth:sanctum');
//Route::post('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordLinkController@store');
//Route::post('/reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@reset');
//Route::get('/reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@redirectToResetForm');
//Route::get('/forgot-password/{token}', 'App\Http\Controllers\Auth\ForgotPasswordController@showResetForm');
//Route::get('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordLinkController@create');

/**
 * admin routes
 */
Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index');
Route::get('/users', 'App\Http\Controllers\Admin\UserController@index');
Route::get('/users/{id}', 'App\Http\Controllers\Admin\UserController@show');
Route::post('/users', 'App\Http\Controllers\Admin\UserController@store');
Route::put('/users/{id}', 'App\Http\Controllers\Admin\UserController@update');
Route::delete('/users/{id}', 'App\Http\Controllers\Admin\UserController@destroy');


/**
 * user routes
 */
