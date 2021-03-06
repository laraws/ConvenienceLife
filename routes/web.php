<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('static_pages.home');
});

Route::resource('weathers', 'WeatherController');
Route::put('/weathers/subscribe/{weather}', 'WeatherController@subscribe')->name('weathers.subscribe');

Route::resource('expresses', 'ExpressController');
Route::put('/expresses/subscribe/{express}', 'ExpressController@subscribe')->name('expresses.subscribe');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');


Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::resource('statuses', "StatusesController", ['only' => ['store', 'destroy']]);

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::any('/wechat', 'WeChatController@serve');
Route::any('/wechat/backUrl', 'WeChatController@backUrl');

