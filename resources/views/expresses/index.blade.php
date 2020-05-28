@extends('layouts.default')
@section('title', 'all expresses')

@section('content')
    <div class="offset-md-2 col-md-8">
        <h2 class="mb-4 text-center">用户物流记录</h2>
        <div class="list-group list-group-flush">
            @foreach ($expresses as $express)
                @include('expresses._express')
            @endforeach
        </div>

        <div class="mt-3">

        </div>
    </div>
@stop
