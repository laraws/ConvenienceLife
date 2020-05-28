@extends('layouts.default')
@section('title', $express->title)
@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="col-md-12">
                <div class="offset-md-2 col-md-8">
                    <section class="user_info">
                        {{--                        @include('shared._user_info', ['user' => $user])--}}
                    </section>
                    <section class="status">
                        <h2 class="text-center">{{ $express->title }}</h2>
                        <p class="mb-0 pb-0">快递公司: {{ $express->company_name }}</p>
                        <p class="mb-0 pb-0">物流单号: {{ $express->tracking_number }}</p>
                        <p class="mb-0 pb-0">签收状态: @switch($express->sign_status)
                                @case(1) 在途中 @break
                                @case(2) 派件中 @break
                                @case(3) 已签收 @break
                                @case(4) 派件失败 @break
                            @endswitch
                        </p>
                        <div class="card">
                            @foreach(json_decode($express->content, true) as $process)
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">时间: {{ $process['time'] }}</p>
                                        <p class="card-text">详情: {{ $process['status'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
