<div id="sidebar-wrapper">

    @if(Auth()->user()->type == "2")

        @include('front.provider.avatar')

        <ul class="sidebar-nav" id="menu-left">
            <li>
                <a class="{{{ (Request::is('provider') ? 'active' : '') }}}" href="{{ url('provider') }}">Providers</a>
            </li>
            <li>
                <a class="{{{ (Request::is('signal') ? 'active' : '') }}}" href="{{ url('signal') }}">Signals</a>
            </li>
            <li>
                <a class="{{{ (Request::is('subscribe') ? 'active' : '') }}}" href="{{ url('subscribe') }}">Subscribes</a>
            </li>
            <!--<li>
                    <a class="{{{ (Request::is('settings') ? 'active' : '') }}}" href="{{ url('settings') }}">Settings</a>
                </li>-->
        </ul>
    @endif

    @if(Auth()->user()->type == "1")

            @include('front.trader.avatar')

            <ul class="sidebar-nav" id="menu-left">
                <li>
                    <a class="{{{ (Request::is('provider') ? 'active' : '') }}}" href="{{ url('provider') }}">Providers</a>
                </li>
                <li>
                    <a class="{{{ (Request::is('signal') ? 'active' : '') }}}" href="{{ url('signal') }}">Signals</a>
                </li>
                <li>
                    <a class="{{{ (Request::is('subscribe') ? 'active' : '') }}}" href="{{ url('subscribe') }}">Subscribes</a>
                </li>
                <li>
                    <a class="{{{ (Request::is('payment') ? 'active' : '') }}}" href="{{ url('payment') }}">Payment history</a>
                </li>
                <!--<li>
                    <a class="{{{ (Request::is('settings') ? 'active' : '') }}}" href="{{ url('settings') }}">Settings</a>
                </li>-->
            </ul>
    @endif

</div>