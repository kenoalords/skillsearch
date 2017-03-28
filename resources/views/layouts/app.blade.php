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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
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

        window.skillsearch = {!! 
            json_encode([
                's3images' => config('skillsearch.s3.images')
            ])
        !!}

    </script>
    <script src="{{ asset('js/star-rating.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top navbar-inverse">
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
                        <img src="{{asset('public/logo-w.png')}}" alt="" class="img-responsive" id="logo">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('people') }}">People</a></li>
                        <!-- <li><a href="{{ route('tasks') }}">Tasks</a></li> -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/home">My Account</a>
                                        <a href="{{ route('requests') }}">Requests</a>
                                        <a href="/profile/portfolio">Portfolio</a>
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

                            @if(Auth::user() && Auth::user()->profile && Auth::user()->profile->account_type === 1)
                                <li>
                                    <a href="/profile/portfolio/add" class="bold">
                                        <i class="glyphicon glyphicon-plus"></i> Add Portfolio
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="/blog/add" class="bold">
                                        <i class="fa fa-edit"></i> Write
                                    </a>
                                </li> -->
                            @endif

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <footer id="site-footer" class="padded">
        <div class="container" id="sub-footer">
            <div class="col-md-4">
                <h4>Company Info</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Term of Use</a></li>
                    <li><a href="#">Report Abuse</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Disclaimer</h4>
                <p>
                    Skillsearch Nigeria is designed to help skilled and talented people in Nigeria showcase their works. We are not laible for what content users post on the platform.
                </p>
                <p>
                    If you discover any copyright infringement or illegalities, <a href="#">kindly contact us.</a>
                </p>
            </div>
        </div>

        <div class="container text-center">
            <hr>
            <ul class="list-inline" id="social-links">
                <li><a href="https://www.facebook.com/skillsearchng/" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com/skillsearchng"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://plus.google.com/skillsearchng"><i class="fa fa-google-plus-square"></i></a></li>
            </ul>

            <br>
            <small>Skillsearch Nigeria &copy; Copyright <?php echo date('Y') ?></small>
        </div>
    </footer>

    <!-- Scripts -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASRW46rAvktIC7IsJFva1gKbPKBYlrpQo&libraries=places&region=ng"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var inputState = document.getElementById('geolocation');
        if(inputState){
            var options = {
              types: ['(cities)'],
              componentRestrictions: {country: 'ng'}
            };

            autocomplete = new google.maps.places.Autocomplete(inputState, options);
        }

        $('#user-badge').affix({
            offset: {
                top: 50,
            },
            target: window
        })
    </script>
</body>
</html>
