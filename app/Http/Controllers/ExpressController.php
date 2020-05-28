<?php

namespace App\Http\Controllers;

use App\Mail\ExpressInfo;
use App\Models\Express;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laraws\Express\Express as ExpressApi;
use Illuminate\Support\Facades\Redis;
use Mail;

class ExpressController extends Controller
{

    public function __construct()
    {
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
    public function index()
    {
        $expresses = Express::where('user_id', Auth::id())->get();
        return view('expresses.index', compact('expresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expresses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ExpressApi $expressApi)
    {
        $tracking_number = $request->tracking_number;
        $title = $request->title;
        $key = 'express:'.$tracking_number;
        $expressInfo = Redis::get($key);
        if (!$expressInfo) {
            $expressInfo = $expressApi->getExpress($tracking_number);
            Redis::set($key, json_encode($expressInfo));
            Redis::expire($key, 3600);
        } else {
            $expressInfo = json_decode($expressInfo, true);
        }


        $express = Express::where('user_id', Auth::id())->where('tracking_number', $tracking_number)->first();

        if ($express) {
            session()->flash('success', '物流记录已经存在, 物流记录更新成功');
            $express->update([
                'title' => $title,
                'content' => json_encode($expressInfo['list']),
                'sign_status' => $expressInfo['deliverystatus']
            ]);
            return redirect()->route('expresses.show', $express);
        } else {
            $express = Express::create([
                'title' => $title,
                'company_name_en' => $expressInfo['type'],
                'company_name' => $expressInfo['typename'],
                'content' => json_encode($expressInfo['list']),
                'tracking_number' => $tracking_number,
                'sign_status' => $expressInfo['deliverystatus'],
                'user_id' => Auth::id()
            ]);
        }


        $this->expressUpdate($express);

//        Mail::to('laraotwell@gmail.com')->send(new ExpressInfo($expressInfo));

        return redirect()->route('expresses.show', $express);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Express $express)
    {
//        $data = json_decode($express->content, true);
        return view('expresses.show', compact('express'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Express $express)
    {
        return view('expresses.edit', compact('express'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Express $express)
    {
        $this->validate($request, [
            'title' => 'required|max:50'
        ]);
        $data = [];
        $data['title'] = $request->title;
        $express->update($data);
        session()->flash('success', '更新物流备注成功！');
        return redirect()->route('expresses.show', $express);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Express $express)
    {
        $express->delete();
        session()->flash('success', '成功删除天气！');
        return back();
    }

    protected function expressUpdate(Express $express)
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
