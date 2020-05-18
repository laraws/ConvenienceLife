<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laraws\Express\Express;
use Illuminate\Support\Facades\Redis;

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

        return $expressInfo;
    }
}
