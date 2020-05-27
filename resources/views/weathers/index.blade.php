@extends('layouts.default')
@section('title', 'all user weather records')

@section('content')
    <div class="offset-md-2 col-md-8">
        <h2 class="mb-4 text-center">用户查询天气记录</h2>
        <div class="list-group list-group-flush">
            @foreach ($weatherInfos as $weatherInfo)
                @include('weathers._weather')
            @endforeach
        </div>

        <div class="mt-3">

        </div>
    </div>
@stop
