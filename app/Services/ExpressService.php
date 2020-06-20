<?php
namespace App\Services;

use App\Mail\ExpressInfo;
use App\Models\Express;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Laraws\Express\Express as ExpressApi;
use Mail;

class ExpressService
{
    public  $expressApi;

    public function __construct(ExpressApi $expressApi)
    {
        $this->expressApi = $expressApi;
    }

    public function expressInfo($tracking_number)
    {
        $key = 'express:'.$tracking_number;
        $expressInfo = Redis::get($key);
        if (!$expressInfo) {
            $expressInfo = $this->expressApi->getExpress($tracking_number);
            if ($expressInfo) {
                Redis::set($key, json_encode($expressInfo));
                Redis::expire($key, 3600);
            }
        } else {
            $expressInfo = json_decode($expressInfo, true);
        }
        return $expressInfo;
    }

    public function expressSave($express, $expressInfo, $request, $uid)
    {
        $express = Express::create([
            'title' => $request->input('title'),
            'company_name_en' => $expressInfo['type'],
            'company_name' => $expressInfo['typename'],
            'content' => json_encode($expressInfo['list']),
            'tracking_number' => $request->tracking_number,
            'sign_status' => $expressInfo['deliverystatus'],
            'user_id' => $uid
        ]);

        return $express;
    }

    public function expressUpdate($express, $expressInfo, $params = [])
    {
        $express->update([
            'title' => $params['title'] ?? $express->title,
            'content' => json_encode($expressInfo['list']),
            'sign_status' => $expressInfo['deliverystatus']
        ]);
        return $express;
    }

    public function expressNotify(Express $express)
    {
//        $view = 'emails.express.update';
//        $data = compact('express');
//        $to = User::find($express->user_id)->email;
//        $subject = '您的'.$express->title.'物流更新';

        Mail::to(User::find($express->user_id))->queue(new ExpressInfo($express));

//        Mail::queue($view, $data, function ($message) use ($to, $subject) {
//            $message->to($to)->subject($subject);
//        });
    }
}
