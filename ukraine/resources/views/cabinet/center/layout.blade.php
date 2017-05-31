<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>System "Test"</title>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- ... -->
    <!-- 1. Подключить библиотеку jQuery -->
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <!-- 2. Подключить скрипт moment-with-locales.min.js для работы с датами -->
    <script type="text/javascript" src="{{asset('js/moment-with-locales.min.js')}}"></script>
    <!-- 3. Подключить скрипт платформы Twitter Bootstrap 3 -->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- 4. Подключить скрипт виджета "Bootstrap datetimepicker" -->
    <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- 5. Подключить CSS платформы Twitter Bootstrap 3 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <!-- 6. Подключить CSS виджета "Bootstrap datetimepicker" -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="{{asset('js/defaults-ru_RU.min.js')}}"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

    <!-- Latest compiled and minified Locales -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-zh-CN.min.js"></script>

    <!-- Styles -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    <link href="{{asset('css/jquery.fileupload-ui.css')}}" rel="stylesheet">

    <!-- Print styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}" media="print">

    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>

    <script src="{{asset('js/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('js/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('js/jquery.fileupload.js')}}"></script>
    <script src="{{asset('js/jquery.print.js')}}"></script>


</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">

        @if (Auth::guest())

        @else

            <div class="row">
                <div class="col-md-6">
                    <div class="title-enterprise">Центральный офис</div>
                </div>

                @endif

                <div class="col-md-6 @if (Auth::guest()) col-sm-offset-4 @endif">
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">

                        @if (Auth::guest())
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="{{ url('/login') }}">Авторизация</a></li>
                                <li><a href="{{ url('/register') }}">Регистрация</a></li>
                            </ul>
                        @else

                            <div class="row">
                                <div class="col-md-10 date-sync">
                                    <!--<div class="row">
                                        <div class="col-md-10">
                                            <div class="last-update">Дата: <strong><?=date("d/m/Y")?></strong></div>
                                            <div class="last-update">Синхронизировано: <strong><?=\Carbon\Carbon::yesterday()->format("d/m/Y")?></strong></div>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-danger" onclick="return Sync(); return false;" href="#"><img src="{{url("images/cloud-computing.png")}}"></a>
                                        </div>
                                    </div>-->
                                </div>


                                <div class="col-md-2">
                                    <a class="btn btn-primary" title="Выйти из аккаунта" href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        <img src="{{url("images/logout.png")}}">
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>

                        @endif

                    </div>
                </div>
            </div>

    </div>
</nav>

<div class="container">
    @include ('cabinet.distributor.common.message-block')
</div>

@yield('content')

<div class="container">
    <footer>
        © <?=date("Y") ?> Test System
    </footer>
</div>

<!-- Scripts -->
</body>
</html>
