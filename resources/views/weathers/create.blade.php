@extends('layouts.default')
@section('title', '天气查询')

@section('content')
    <div class="offset-md-2 col-md-8">
        <div class="card ">
            <div class="card-header">
                <h5>天气查询</h5>
            </div>
            <div class="card-body">

                @include('shared._errors')

                <form method="POST" action="{{ route('weathers.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">备注：</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">查询</button>
                </form>
            </div>
        </div>
    </div>
@stop
