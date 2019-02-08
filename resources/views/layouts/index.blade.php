<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO META TAGS -->
    <meta name="description" content="@yield('metadescription')">


    <title>@yield('title') - {{ config('app.name', 'Ubanji') }} | {{ config('app.description') }}</title>
    @yield('seometa')

    <meta name="twitter:card" content="@yield('metadescription')">
    <meta name="twitter:site" content="@skillsearchng">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('metadescription')">
    <meta name="twitter:creator" content="@skillsearchng">
    <!-- Twitter Summary card images must be at least 120x120px -->
    <meta name="twitter:image" content="@yield('thumbnail')">

    <!-- Open Graph data -->
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="@yield('type')" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:image" content="@yield('thumbnail')" />
    <meta property="og:description" content="@yield('metadescription')" /> 
    <meta property="og:site_name" content="{{config('app.name')}}" />
    
    <!-- Styles -->
    <link rel="icon" href="{{ asset('public/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel  = {!! json_encode([
            'csrfToken'     => csrf_token(),
            'url'           => config('app.url'),
            'userLoggedIn'  => (Auth::user()) ? true : false,
            'user_id'       => (Auth::user()) ? Auth::user()->id : 0,
            'is_admin'      => (Auth::user() && Auth::user()->is_admin) ? Auth::user()->id : 0,
        ]) !!};

        window.skillsearch = {!! 
            json_encode([
                's3images' => config('skillsearch.s3.images')
            ])
        !!}

    </script>
    
</head>
<body id="index">
    <div id="app">
        <div id="mobile-menu-admin" class="ui sidebar mobile only column">
            <div class="ui vertical menu">
                @if(Auth::user())
                    <a class="item" href="/home"><i class="icon user"></i>{{ ucwords(Auth::user()->name) }}</a>
                @endif
                <a class="item" href="{{ route('people') }}">People</a>
                <a class="item" href="{{ route('tasks') }}">Jobs</a>
                @if(!Auth::user())
                <a href="/login" class="item">Login</a>
                <div class="item">
                    <a href="/register" class="ui green circular button">Sign Up</a>
                </div>
                @else
                    <a class="item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="icon power"></i>Logout
                    </a>
                @endif
            </div> 
        </div>
        <div class="pusher">
            <nav class="navbar" id="primary-nav">
                <div class="item">
                    <div>
                        <a href="#" id="mobile-admin-trigger"><i class="icon large sidebar"></i></a>
                    </div>
                    <!-- Branding Image -->
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('public/ubanji-logo.png') }}" alt="{{config('app.name')}} Logo" class="img-responsive" id="logo" style="width: 80px; height: auto;">
                    </a>
                </div>
                <a class="item large-screen-only" href="{{ route('people') }}">People</a>
                <a class="item large-screen-only" href="{{ route('tasks') }}">Jobs</a>
                @if(Auth::user() && Auth::user()->is_admin == 1)
                    <a href="{{ route('gigs') }}" class="item">Gigs</a>        
                @endif
                
                <div class="right menu">
                    @if(Auth::user())
                    <a class="item large-screen-only" href="/home"><i class="icon user"></i>{{ ucwords(Auth::user()->name) }}</a>
                    <a class="item large-screen-only" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="icon power"></i>Logout
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    @else
                        <a href="/login" class="item large-screen-only">Login</a>
                        <a href="/register" class="item large-screen-only">Register</a>
                    @endif 
                    <div class="item">
                        <a href="/profile/portfolio/add" class="ui green mini button"><i class="icon plus"></i>Upload work</a>
                    </div>
                    @if(Auth::user() && Auth::user()->is_admin == 1)
                        <div class="item">
                            <a href="/cart" class="ui circular icon button"><i class="icon cart"></i></a>
                        </div>
                    @endif
                </div>
            </nav>
            
            @yield('content')
        

            <footer id="site-footer">
                <div class="ui two column grid container" id="sub-footer">
                    <div class="column" id="links">
                        <div class="ui horizontal list">
                            <div class="item"><a href="/about">About</a></div>
                            <div class="item"><a href="/how-it-works">How It Works</a></div>
                            <div class="item"><a href="/points">Points</a></div>
                            <div class="item"><a href="/contact">Contact Us</a></div>
                        </div>
                    </div>
                    <div class="right aligned column">
                        <div class="ui horizontal list">
                            <div class="item">
                                <a href="https://www.facebook.com/ubanjicreatives/" target="_blank" class="ui icon facebook circular mini button"><i class="icon facebook"></i></a>
                            </div>
                            <div class="item">
                                <a href="https://instagram.com/ubanjicreatives" class="ui icon instagram circular mini button"><i class="icon instagram"></i></a>
                            </div>
                        </div>
                    </div>
                 </div>
            </footer>  
        </div>
    </div>  
    
    
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
 
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-75152211-1', 'auto');
      ga('send', 'pageview');

    </script>

</body>
</html>
