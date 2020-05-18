<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laraws\Express\Express;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpressInfo;

class ExpressController extends Controller
{
    public function show(Request $request, Express $express, $number)
    {
        $key = 'express:'.$number;
        $expressInfo = Redis::get($key);
        if (!$expressInfo) {
            $expressInfo = json_encode($express->getExpress($number));
            Redis::set($key, $expressInfo);
        }

//        $order = Order::findOrFail($orderId);

        // Ship order...

        Mail::to('laraotwell@gmail.com')->send(new ExpressInfo($expressInfo));

        return $expressInfo;
    }
}
