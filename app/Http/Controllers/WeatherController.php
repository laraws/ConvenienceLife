<?php

namespace App\Http\Controllers;

use App\Mail\WeatherInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laraws\Weather\Weather as WeatherApi;
use App\Models\Weather;
use Illuminate\Support\Facades\Redis;
use Mail;
use App\Models\User;
use APP\Services\WeatherService;

class WeatherController extends Controller
{

    public $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
//        $this->middleware('guest', [
//            'only' => ['create']
//        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $weatherInfos = Weather::where('user_id', $user->id)->get();
        return view('weathers.index', compact('weatherInfos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminafunciton and uite\Http\Response
     */
    public function create()
    {
        return view('weathers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, WeatherApi $weatherApi)
    {
        $city = $request->input('city') ?? abort(404);
        $type = $request->input('type') ?? 'base';
        $user_id = Auth::id();
        $keyLimit = 'weathers:user:' . $user_id;
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
            $result = $weatherApi->getWeather($city, $type);
            $weatherInfo = $result['lives'][0];
            Redis::set($keyWeather, json_encode($weatherInfo));
            Redis::expire($keyWeather, 3600);
        }
        $weather = Weather::where('title', 'like', '%' . $city . '%')->where('user_id', 0)->first();
        if ($weather) {
            $weather->update([
                'content' => json_encode($weatherInfo)
            ]);
        } else {
            $weather = Weather::create([
                'title' => $weatherInfo['city'] . 'live',
                'content' => json_encode($weatherInfo),
                'user_id' => $user_id
            ]);
        }

        Redis::incr($keyLimit);

        $this->weatherUpdate($weather);


        return redirect()->route('weathers.show', $weather);

    }

    private function weatherUpdate($weather)
    {
        Mail::to(User::find($weather->user_id))->queue(new WeatherInfo($weather));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Weather $weather)
    {
        $weatherInfo = Weather::find($weather->id);
        return view('weathers.show', compact('weatherInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Weather $weather)
    {
        $weatherInfo = Weather::find($weather->id);

        return view('weathers.edit', compact('weatherInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weather $weather)
    {
        $type = $request->input('type') ?? 'info';
        $this->validate($request, [
            'title' => 'required|max:50',
        ]);
        if ($type == 'data') {
            $expressInfo = $this->weatherService->weatherInfo($weather->title);
            if (!$expressInfo) {
                session()->flash('failed', '天气信息为空');
                return redirect()->route('weathers.show', $weather);
            }
            $params['type'] = $type;
            $params['title'] = $request->title;
            $express = $this->weatherService->weatherUpdate($weather, $expressInfo, $params);
        } else {
            $data = [];
            $data['title'] = $request->title;
            $weather->update($data);
        }
        session()->flash('success', '更新天气信息成功！');
        return redirect()->route('weathers.show', $weather);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weather $weather)
    {
        $weather->delete();
        session()->flash('success', '成功删除天气！');
        return back();
    }

    public function subscribe(Weather $weather)
    {
        $hasSubscribe = $weather->has_subscribed;
        if ($hasSubscribe) {
            $weather->update(['has_subscribed' => 0]);
            session()->flash('success', '取消订阅成功！');
        } else {
            $weather->update(['has_subscribed' => 1]);
            session()->flash('success', '订阅成功！');
        }

        return back();
    }
}
