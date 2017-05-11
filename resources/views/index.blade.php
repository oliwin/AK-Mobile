<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <link rel="Shortcut Icon" href="http://snipethetrade.com/wp-content/themes/snipthetrade/img/favicon.ico"
          type="image/x-icon">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui">
    <title>Admin Panel - Game</title>

    <!-- Scripts-->
    <script
            src="https://code.jquery.com/jquery-3.1.1.js"
            integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
            crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>


            <script src="{{URL::asset('js/custom.js')}}"></script>

    <!-- CSS -->
    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/custom.css')}}" rel="stylesheet">

</head>
<body>

@include('common.header')

<div class="container target" id="main-container">
    <div class="col-lg-3 col-md-3 col-sm-4">

          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Menu</h3>
            </div>
            <div class="panel-body">

                                  <a class="{{ (Request::is('objects') || Request::is('objects/*') ? 'active' : '') }} list-group-item"
                                     href="{{url('objects')}}">Objects</a>
                                  <a class="{{ (Request::is('prototypes') || Request::is('prototypes/*') ? 'active' : '') }} list-group-item"
                                     href="{{url('prototypes')}}">Prototypes</a>
                                     <a class="{{ (Request::is('fields') || Request::is('fields/*') ? 'active' : '') }} list-group-item"
                                        href="{{url('fields')}}">Parameters</a>
            </div>
          </div>
    </div>

    <div class="col-sm-9">
        <div id="content">
            @include('common.messages-success')
            @include('common.messages-error')
            @yield('content')
        </div>
    </div>

    @include("common.footer")

</div>

<!-- #### Developed by Oleg Ponomarchuk | ponomarchukov@gmail.com ########## -->

</body>
</html>
