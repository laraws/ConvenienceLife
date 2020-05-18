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
//    dump(config('services.weather.key'));
//    dump(config('services.ses.region'));
    return view('welcome');
});

Route::get('weather/{city}', 'WeatherController@show');

Route::get('express/{number}', 'ExpressController@show');

