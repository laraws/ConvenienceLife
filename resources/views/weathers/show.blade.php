@extends('layouts.default')
@section('title', $weatherInfo->title)
@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="col-md-12">
                <div class="offset-md-2 col-md-8">
                    <section class="user_info">
                        {{--                        @include('shared._user_info', ['user' => $user])--}}
                    </section>
                    <section class="status">
                        <h2 class="text-center">{{ $weatherInfo->title }}</h2>
                        <p class="mb-0 pb-0">省份: {{ json_decode($weatherInfo->content, true)['province'] }}</p>
                        <p class="mb-0 pb-0">城市: {{ json_decode($weatherInfo->content, true)['city'] }}</p>
                        <p class="mb-0 pb-0">天气: {{ json_decode($weatherInfo->content, true)['weather'] }}</p>
                        <p class="mb-0 pb-0">温度: {{ json_decode($weatherInfo->content, true)['temperature'] }}</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
