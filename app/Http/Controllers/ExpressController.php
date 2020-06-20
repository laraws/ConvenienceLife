<?php

namespace App\Http\Controllers;

use App\Mail\ExpressInfo;
use App\Models\Express;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Mail;
use App\Services\ExpressService;

class ExpressController extends Controller
{
    public $expressService;


    public function __construct(ExpressService $expressService)
    {
        $this->expressService = $expressService;
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
    public function store(Request $request)
    {
        $tracking_number = $request->tracking_number;
        $title = $request->title;
        $expressInfo = $this->expressService->expressInfo($tracking_number);
        if (!$expressInfo) {
            session()->flash('failed', '物流信息为空');
            return view('expresses.create');
        }
        $express = Express::where('user_id', Auth::id())->where('tracking_number', $tracking_number)->first();

        if ($express) {
            session()->flash('success', '物流记录已经存在, 物流记录更新成功');
            $params['title'] = $request->title;
            $express = $this->expressService->expressUpdate($express, $expressInfo, $request);
        } else {
            $express = $this->expressService->expressSave($express, $expressInfo, $request, Auth::id());
        }


        $this->expressService->expressNotify($express);

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
        $type = $request->input('type') ?? 'info';
        $this->validate($request, [
            'title' => 'max:50'
        ]);
        if ($type == 'data') {
            $expressInfo = $this->expressService->expressInfo($express->tracking_number);
            if (!$expressInfo) {
                session()->flash('failed', '物流信息为空');
                return redirect()->route('expresses.show', $express);
            }
            $params['type'] = $type;
            $params['title'] = $request->title;
            $express = $this->expressService->expressUpdate($express, $expressInfo, $params);
        } else {
            $data = [];
            $data['title'] = $request->title;
            $express->update($data);
        }

        session()->flash('success', '更新物流成功！');
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
        session()->flash('success', '成功删除物流信息！');
        return back();
    }

    public function subscribe(Express $express)
    {
        $hasSubscribe = $express->has_subscribed;
        if ($hasSubscribe) {
            $express->update(['has_subscribed' => 0]);
            session()->flash('success', '取消订阅成功！');
        } else {
            $express->update(['has_subscribed' => 1]);
            session()->flash('success', '订阅成功！');
        }

        return back();
    }
}
