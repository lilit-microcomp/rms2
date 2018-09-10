header for developer
<div>
    <a class="navbar-brand" href="{{ url('/') }}" style="color: black;">
        {{ config('app.name', 'MICROCOMP') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</div>
@if(Auth::check())
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">

        <br>
        <div style="background-color: #f2f2f2; width: 100%;">
            <div class="collapse navbar-collapse tutorial" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <a href="/"><img src="{{URL::asset('/img/home_dashboard.png')}}" alt="project url" style="margin-left: 40px; margin-right: 10px; margin-top: -5px;"></a>

                <ul class="navbar-nav mr-auto">
                    <!--<li class="nav-item active">
                        <a class="nav-link" href="{{ route('users.index') }}">Users<span class="dropdown-toggle" style="font-size: 14px; color: black; margin-left: 5px;"></span> </a>
                    </li>
                    <li class="nav-item">
                         asdfghj<a class="nav-link" href="projects">  Projects<span class="dropdown-toggle" style="font-size: 14px; color: black; margin-left: 5px;"></span></a>
                        <ul>
                            <li><a class="nav-link" href="{{ route('projects.index') }}">Projects sub</a></li>
                        </ul>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tasks.index') }}">Tasks<span class="dropdown-toggle" style="font-size: 14px; color: black; margin-left: 5px;"></span></a>
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <ul>
                            <li><a class="nav-link" href="">Search</a></li>
                        </ul>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('support.index') }}">Support<span class="dropdown-toggle" style="font-size: 14px; color: black; margin-left: 5px;"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('thirdparty.index') }}">Third Party</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto" style="background-color: #3ba0f7;">
                    <!-- Authentication Links -->
                @guest
                    <!-- <li><a class="nav-link" href="{{ route('login') }}">Login</a></li> -->
                    <!-- <li><a class="nav-link" href="{{ route('register') }}">Register</a></li> -->
                        @else
                            <li class="nav-item dropdown" >
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                                    {{ Auth::user()->name }} <span style="color: white;">Account</span><span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('users.edit_account')}}">Edit account</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                </ul>
            </div>
        </div>



    </div>
</nav>
@endif
