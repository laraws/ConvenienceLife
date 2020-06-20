<?php
namespace APP\Services;

use App\Mail\WeatherInfo;
use App\Models\Weather;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Laraws\Weather\Weather as WeatherApi;
use Mail;

class WeatherService
{
    public  $weatherApi;

    public function __construct(WeatherApi $weatherApi)
    {
        $this->weatherApi = $weatherApi;
    }

    public function expressInfo($city)
    {
        $key = 'weather:'.$city;
        $weatherInfo = Redis::get($key);
        if (!$weatherInfo) {
            $weatherInfo = $this->weatherApi->getExpress($city);
            if ($weatherInfo) {
                Redis::set($key, json_encode($weatherInfo));
                Redis::expire($key, 3600);
            }
        } else {
            $weatherInfo = json_decode($weatherInfo, true);
        }
        return $weatherInfo;
    }

    public function expressSave($weather, $weatherInfo, $request, $uid)
    {
        $weather = Weather::create([
            'title' => $weatherInfo['city'] . 'live',
            'content' => json_encode($weatherInfo),
            'user_id' => $uid
        ]);

        return $weather;
    }

    public function expressUpdate($weather, $weatherInfo, $params = [])
    {
        $weather->update([
            'content' => json_encode($weatherInfo)
        ]);
        return $weather;
    }

    public function expressNotify(Weather $weather)
    {
//        $view = 'emails.express.update';
//        $data = compact('express');
//        $to = User::find($weather->user_id)->email;
//        $subject = '您的'.$weather->title.'物流更新';

        Mail::to(User::find($weather->user_id))->queue(new WeatherInfo($weather));

//        Mail::queue($view, $data, function ($message) use ($to, $subject) {
//            $message->to($to)->subject($subject);
//        });
    }
}
