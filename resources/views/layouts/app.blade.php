<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" prefix="og: http://ogp.me/ns#">
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

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@ubanjicreatives">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('metadescription')">
    <meta name="twitter:creator" content="@ubanjicreatives">
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
            'images'        => asset('/public'),
            'search'        => Request::get('term'),
        ]) !!};

        window.skillsearch = {!! 
            json_encode([
                's3images' => config('skillsearch.s3.images')
            ])
        !!}

    </script>
    @if ( App::environment() === 'production' )
    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '295224574467461');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=295224574467461&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    @endif
    
</head>
<body>
    <div id="app">
        <noscript>
          <div class="notification is-danger">
            JavaScript Disabled: This website requires JavaScript to function properly. To enable JavaScript on your browser, <a href="https://enablejavascript.co/">please click here</a>.
          </div>
        </noscript>
        @include('includes.menu') 
        
        @yield('content')
        
        @include('includes.footer')
    </div>  
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
   
    @stack('script')
    @if ( App::environment() === 'production' )
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-75152211-1', 'auto');
      ga('send', 'pageview');

    </script>
    @endif
</body>
</html>
