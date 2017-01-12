@extends('layouts.default')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            www.weektrip.cn
        </p>
        <p>一切，将从这里开始。</p>
        <p>
            <a href="{{ route('signup') }}" class="btn btn-lg btn-success" role="button">现在注册</a>
        </p>
    </div>
@stop