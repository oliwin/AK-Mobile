@extends('home')

@section('content_right_block')

@if (session('unique_code'))
    <div id="result-ticket-view" class="registered-unique-code-client">

        <div id="form-print">
            <span>ФИО:</span>
            <span class="fio">{{ session('fio') }}</span>

            <span>Код регистрации:</span>
            <span class="unique_code">{{ session('unique_code') }}</span>
        </div>

        <div class="actions-list">
            <a onclick="printDiv('form-print')" href="#" class="btn btn-success">Печать</a>
            <a class="btn btn-danger" href="{{ url('/cabinet/test/form') }}">Новая анкета</a>
            <a class="btn btn-default" href="{{ url('/cabinet/statistic') }}">Список тестрируемых</a>
        </div>
    </div>
@endif

@endsection