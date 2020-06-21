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

    public function weatherInfo($city, $type, $uid)
    {
        $keyLimit = 'weathers:user:' . $uid;
        $times = Redis::get($keyLimit);
        if ($times >= 10) {
            session()->flash('success', '查询次数达到限制！');
            return redirect()->route('weathers.index');
        }
        $keyWeather = 'weathers:user:' . md5($city);
        $weatherInfo = Redis::get($keyWeather);
        if ($weatherInfo) {
            $weatherInfo = json_decode($weatherInfo, true);
        } else {
            $result = $this->weatherApi->getWeather($city, $type);
            $weatherInfo = $result['lives'][0];
            Redis::set($keyWeather, json_encode($weatherInfo));
            Redis::expire($keyWeather, 3600);
        }
        Redis::incr($keyLimit);
        return $weatherInfo;
    }

    public function weatherSave($weather, $weatherInfo, $request, $uid)
    {
        $weather = Weather::create([
            'title' => $weatherInfo['city'] . 'live',
            'city' => $weatherInfo['city'],
            'content' => json_encode($weatherInfo),
            'user_id' => $uid,
            'type' => 1
        ]);

        return $weather;
    }

    public function weatherUpdate($weather, $weatherInfo, $params = [])
    {
        $weather->update([
            'content' => json_encode($weatherInfo)
        ]);
        return $weather;
    }

    public function weatherNotify(Weather $weather)
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
