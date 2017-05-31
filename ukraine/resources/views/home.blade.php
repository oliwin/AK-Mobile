@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
      
            @include('cabinet.distributor.common.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default container-fluid">
                    <div class="row">

                    <!--<div id="current-date"><?=date("d/m/Y")?></div>
                        <div class="begin-test-block">
                            <a class="btn btn-success" href="{{ url('/cabinet/test') }}">Начать тестирование</a>
                        </div>-->

                        @yield('content_right_block')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
