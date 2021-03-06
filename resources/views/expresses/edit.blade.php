@extends('layouts.default')
@section('title', 'update weather info')

@section('content')
    <div class="offset-md-2 col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>update weather info</h5>
            </div>
            <div class="card-body">
                @include('shared._errors')
                <form method="POST" action="{{ route('expresses.update', $express->id )}}">
                    {{ method_field("PATCH") }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">备注：</label>
                        <input type="text" name="title" class="form-control" value="{{ $express->title }}">
                    </div>

                    <button type="submit" class="btn btn-primary">更新</button>
                </form>
            </div>
        </div>
    </div>
@stop
