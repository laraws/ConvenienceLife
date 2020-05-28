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

                <form method="POST" action="{{ route('expresses.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">备注：</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="name">单号：</label>
                        <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">查询</button>
                </form>
            </div>
        </div>
    </div>
@stop
