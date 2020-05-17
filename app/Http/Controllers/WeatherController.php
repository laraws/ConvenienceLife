<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laraws\Weather\Weather;

class WeatherController extends Controller
{
    public function show(Request $request, Weather $weather, $city)
    {
        return $weather->getWeather($city);
    }

//    public function show(Request $request,$city)
//    {
//        return app('weather')->getWeather($city);
//    }
}
