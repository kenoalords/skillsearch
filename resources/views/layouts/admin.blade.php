<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO META TAGS -->
    <meta name="description" content="@yield('metadescription')">


    <title>@yield('title') - {{ config('app.name', 'Ubanji') }} | {{ config('app.description') }}</title>
    @yield('seometa')
    
    <!-- Styles -->
    <link rel="icon" href="{{ asset('public/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
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
</head>
<body>
    <div id="mobile-menu-admin" class="ui sidebar mobile only column">
        @include('includes.sidebar-mobile') 
    </div>
    <div id="app" class="dashboard">
        <nav class="ui top fixed borderless menu" id="primary-nav">
            <div class="item">
                <div>
                    <a href="#" id="mobile-admin-trigger"><i class="icon large sidebar"></i></a>
                </div>
                <!-- Branding Image -->
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/ubanji-logo.png') }}" alt="{{config('app.name')}} Logo" class="img-responsive" id="logo" style="width: 80px; height: auto;">
                </a>
            </div>


            
            <div class="right menu">
                <a class="item large-screen-only" href="/home"><i class="icon user"></i>{{ ucwords(Auth::user()->name) }}</a>
                <a class="item large-screen-only" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="icon power"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <div class="item">
                    <a href="/profile/portfolio/add" class="ui green button"><i class="icon plus"></i>Upload work</a>
                </div>
            </div>
            
        </nav>
        
        <div class="" id="app-wrapper">
            <div class="ui padded grid">
                <div class="four wide tablet only three wide computer only column" id="admin-sidebar" style="padding-right: 0em; padding-left: 0em">
                    <div class="content-wrapper">
                        @include('includes.admin-sidebar')
                    </div>
                </div>
                <div class="sixteen wide mobile twelve wide tablet thirteen wide computer white-boxed column admin-content">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script src="{{ mix('js/app.js') }}"></script>
    
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
