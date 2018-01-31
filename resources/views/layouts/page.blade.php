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


    <title>@yield('title') - {{ config('app.name', 'Ubanji') }}</title>
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
<body>
    <div id="app">
        
        <div>
            <nav class="navbar is-fixed-top is-transparent is-dark" id="primary-nav" role="navigation">
                <div class="navbar-brand">
                    <!-- Branding Image -->
                    <a href="{{ url('/') }}" class="navbar-item">
                        <img src="{{ asset('public/ubanji-logo-w.png') }}" alt="{{config('app.name')}} Logo">
                    </a>
                    <button class="navbar-burger" id="app-menu-tigger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item" href="{{ route('people') }}">People</a>
                        <a class="navbar-item" href="{{ route('showcase') }}">Showcase</a>
                        <a class="navbar-item" href="{{ route('tasks') }}">Jobs</a>
                    </div>
                    <div class="navbar-end">
                        @if(Auth::user())
                            @include('includes.user-badge')
                        @else
                            <a href="/login" class="navbar-item">Login</a>
                            <a href="/register" class="navbar-item">Register</a>
                        @endif 
                        <div class="navbar-item">
                            <a href="/dashboard/portfolio/add" class="button is-danger">
                                <span class="icon"><i class="fa fa-plus"></i></span> <span>Upload work</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>  
        <div class="hero is-medium">
            <div class="hero-body">
                <div class="columns is-centered">
                    <div class="column is-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer is-dark">
            <div class="hero">
                <div class="hero-body">
                    <div class="columns is-centered">
                        <div class="column is-10">
                            <div class="level is-mobile">
                                <div class="level-left" id="footer-links">
                                    <div class="level-item"><a href="/about">About</a></div>
                                    <div class="level-item"><a href="/how-it-works">How It Works</a></div>
                                    <div class="level-item"><a href="/points">Points</a></div>
                                    <div class="level-item"><a href="/contact">Contact Us</a></div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <a href="https://www.facebook.com/ubanjicreatives/" target="_blank" class="button is-small is-link"><i class="fa fa-facebook"></i></a>
                                    </div>
                                    <div class="level-item">
                                        <a href="https://instagram.com/ubanjicreatives" class="button is-small is-info"><i class="fa fa-instagram"></i></a>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </footer>  
    </div>  
    
    
    
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
 
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
