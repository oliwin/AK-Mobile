<nav class="navbar navbar-default" id="navbar-header">
    <div class="container">
        <div class="col-md-12">
            <div class="navbar-header">
                <a href="{{url('/')}}" id="logo"><img src="{{asset("images/logo.png")}}" alt="Admin Panel"></a>
                <span>Admin Panel</span>
            </div>

            @if(Auth::check())
            <div id="profile-menu">
                  <ul role="menu">
                                <li><span class="name">{{Auth::user()->name}}</span></li>
                                <li><a href="#" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        <i class="glyphicon glyphicon-log-out"></i></a></li>
                            </ul>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>

            </div>
            @endif
        </div>
    </div>
</nav>
