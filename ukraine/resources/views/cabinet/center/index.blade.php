@extends('cabinet.center.layout')

@section('content')
    <div class="container">
        <div class="row">
            @include('cabinet.center.common.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default container-fluid">
                    <div class="row">
                        @yield('content_right_block')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
