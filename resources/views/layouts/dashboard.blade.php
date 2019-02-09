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
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,900|Noto+Serif:700,900">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
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
    <div id="app" class="dashboard">
        
        @include('includes.menu') 
        <div class="columns is-marginless">
            <aside class="column is-2-widescreen is-3-desktop is-touch is-hidden-touch is-paddingless" id="sidebar">
                <div class="content-wrapper">
                    @include('includes.admin-sidebar')
                </div>
            </aside>
            <div class="column is-10-widescreen is-9-desktop is-white" style="background: #fff; min-height: 95vh">
                <div class="hero">
                    <div class="hero-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
        
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
