@extends('home')

@section('content_right_block')

    <div class="begin-test-block">
        <a class="btn btn-danger" href="{{ url('/cabinet/test/file') }}">Загрузить файл</a>
        <a class="btn btn-success" href="{{ url('/cabinet/test/form') }}">Зарегистрировать через форму</a>
    </div>

@endsection