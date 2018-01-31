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
    <div id="app">
        <nav class="navbar is-transparent is-dark is-fixed-top">
            <div class="navbar-brand">
                <!-- Branding Image -->
                <a href="{{ url('/') }}" class="navbar-item">
                    <img src="{{ asset('public/ubanji-logo-w.png') }}" alt="{{config('app.name')}} Logo">
                </a>
                <button class="button navbar-burger" id="admin-menu-trigger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    @include('includes.user-badge')
                    <div class="navbar-item">
                        <a href="/profile/portfolio/add" class="button is-danger"><i class="fa fa-plus"></i> &nbsp; Upload work</a>
                    </div>
                </div>
            </div>
            
        </nav>
        
        <div class="columns is-marginless">
            <aside class="column is-2-widescreen is-3-desktop is-touch is-hidden-touch is-paddingless" id="sidebar">
                <div class="content-wrapper">
                    @include('includes.admin-sidebar')
                </div>
            </aside>
            <div class="column is-10-widescreen is-9-desktop is-white is-raised" style="background: #fff; min-height: 95vh">
                <div class="hero">
                    <div class="hero-body">
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
