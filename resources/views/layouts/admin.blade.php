<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/star-rating.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel  = {!! json_encode([
            'csrfToken'     => csrf_token(),
            'url'           => config('app.url'),
            'userLoggedIn'  => (Auth::user()) ? true : false,
            'user_id'       => (Auth::user()) ? Auth::user()->id : 0,
        ]) !!};

    </script>
    <script src="{{ asset('js/star-rating.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="col-md-12">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('people') }}">People</a></li>
                        <li><a href="{{ route('tasks') }}">Tasks</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><a href="{{ route('add_task') }}">Submit Task</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/home">Home</a>
                                        <a href="{{ route('message') }}">Message</a>
                                        <a href="{{ route('requests') }}">Requests</a>
                                        <a href="{{ route('user_tasks') }}">Tasks</a>
                                        <a href="/profile/portfolio">Portfolio</a>
                                        <a href="{{ route('edit_profile') }}">Edit Profile</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASRW46rAvktIC7IsJFva1gKbPKBYlrpQo&libraries=places&region=ng"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var inputState = document.getElementById('geolocation');
        var options = {
          types: ['(cities)'],
          componentRestrictions: {country: 'ng'}
        };

        autocomplete = new google.maps.places.Autocomplete(inputState, options);
    </script>
</body>
</html>
