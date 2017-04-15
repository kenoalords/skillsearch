<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO META TAGS -->
    <meta name="description" content="@yield('metadescription')">


    <title>@yield('title') {{ config('app.name', 'Skillsearch Nigeria') }} | {{ config('app.description') }}</title>
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

    <style>
        html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}nav{display:block}a{background-color:transparent}small{font-size:80%}img{border:0}button{color:inherit;font:inherit;margin:0;overflow:visible;text-transform:none;-webkit-appearance:button}button::-moz-focus-inner{border:0;padding:0}@font-face{font-family:Glyphicons Halflings;src:url(/fonts/glyphicons-halflings-regular.eot?f4769f9bdb7466be65088239c12046d1);src:url(/fonts/glyphicons-halflings-regular.eot?f4769f9bdb7466be65088239c12046d1?#iefix) format("embedded-opentype"),url(/fonts/glyphicons-halflings-regular.woff2?448c34a56d699c29117adc64c43affeb) format("woff2"),url(/fonts/glyphicons-halflings-regular.woff?fa2772327f55d8198301fdb8bcfc8158) format("woff"),url(/fonts/glyphicons-halflings-regular.ttf?e18bbf611f2a2e43afc071aa2f4e1512) format("truetype"),url(/fonts/glyphicons-halflings-regular.svg?89889688147bd7575d6327160d64e760#glyphicons_halflingsregular) format("svg")}.glyphicon{position:relative;top:1px;display:inline-block;font-family:Glyphicons Halflings;font-style:normal;font-weight:400;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.glyphicon-heart:before{content:"\E005"}.glyphicon-camera:before{content:"\E046"}.glyphicon-facetime-video:before{content:"\E059"}.glyphicon-eye-open:before{content:"\E105"}.glyphicon-comment:before{content:"\E111"}*,:after,:before{box-sizing:border-box}html{font-size:10px}body{font-family:Raleway,sans-serif;font-size:14px;line-height:1.6;color:#636b6f;background-color:#f5f8fa}button{font-family:inherit;font-size:inherit;line-height:inherit}a{color:#3097d1;text-decoration:none}img{vertical-align:middle}.img-responsive{display:block;max-width:100%}.img-circle{border-radius:50%}.sr-only{position:absolute;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);border:0}h3,h5{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}h3{margin-top:22px;margin-bottom:11px}h5{margin-top:11px;margin-bottom:11px}h3{font-size:24px}h5{font-size:14px}p{margin:0 0 11px}small{font-size:85%}.text-center{text-align:center}.text-muted{color:#777}ul{margin-top:0;margin-bottom:11px}.list-inline{padding-left:0;list-style:none;margin-left:-5px}.list-inline>li{display:inline-block;padding-left:5px;padding-right:5px}.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.container:after,.container:before{content:" ";display:table}.container:after{clear:both}@media (min-width:768px){.container{width:750px}}@media (min-width:992px){.container{width:970px}}@media (min-width:1200px){.container{width:1170px}}.row{margin-left:-15px;margin-right:-15px}.row:after,.row:before{content:" ";display:table}.row:after{clear:both}.col-lg-2,.col-md-3,.col-md-8,.col-md-12,.col-sm-4,.col-xs-12{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-12{float:left;width:100%}@media (min-width:768px){.col-sm-4{float:left;width:33.33333333%}}@media (min-width:992px){.col-md-3,.col-md-8,.col-md-12{float:left}.col-md-3{width:25%}.col-md-8{width:66.66666667%}.col-md-12{width:100%}.col-md-offset-2{margin-left:16.66666667%}}@media (min-width:1200px){.col-lg-2{float:left;width:16.66666667%}.col-lg-offset-0{margin-left:0}}.btn{display:inline-block;margin-bottom:0;font-weight:400;text-align:center;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;background-image:none;border:1px solid transparent;white-space:nowrap;padding:6px 12px;font-size:14px;line-height:1.6;border-radius:4px}.btn-primary{color:#fff;background-color:#3097d1;border-color:#2a88bd}.collapse{display:none}.nav{margin-bottom:0;padding-left:0;list-style:none}.nav:after,.nav:before{content:" ";display:table}.nav:after{clear:both}.nav>li,.nav>li>a{position:relative;display:block}.nav>li>a{padding:10px 15px}.navbar{position:relative;min-height:50px;margin-bottom:22px;border:1px solid transparent}.navbar:after,.navbar:before{content:" ";display:table}.navbar:after{clear:both}@media (min-width:768px){.navbar{border-radius:4px}}.navbar-header:after,.navbar-header:before{content:" ";display:table}.navbar-header:after{clear:both}@media (min-width:768px){.navbar-header{float:left}}.navbar-collapse{overflow-x:visible;padding-right:15px;padding-left:15px;border-top:1px solid transparent;box-shadow:inset 0 1px 0 hsla(0,0%,100%,.1);-webkit-overflow-scrolling:touch}.navbar-collapse:after,.navbar-collapse:before{content:" ";display:table}.navbar-collapse:after{clear:both}@media (min-width:768px){.navbar-collapse{width:auto;border-top:0;box-shadow:none}.navbar-collapse.collapse{display:block!important;height:auto!important;padding-bottom:0;overflow:visible!important}.navbar-static-top .navbar-collapse{padding-left:0;padding-right:0}}.navbar-static-top{z-index:1000;border-width:0 0 1px}@media (min-width:768px){.navbar-static-top{border-radius:0}}.navbar-brand{float:left;padding:14px 15px;font-size:18px;line-height:22px;height:50px}.navbar-brand>img{display:block}.navbar-toggle{position:relative;float:right;margin-right:15px;padding:9px 10px;margin-top:8px;margin-bottom:8px;background-color:transparent;background-image:none;border:1px solid transparent;border-radius:4px}.navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px}.navbar-toggle .icon-bar+.icon-bar{margin-top:4px}@media (min-width:768px){.navbar-toggle{display:none}}.navbar-nav{margin:7px -15px}.navbar-nav>li>a{padding-top:10px;padding-bottom:10px;line-height:22px}@media (min-width:768px){.navbar-nav{float:left;margin:0}.navbar-nav>li{float:left}.navbar-nav>li>a{padding-top:14px;padding-bottom:14px}}@media (min-width:768px){.navbar-right{float:right!important;margin-right:-15px}}.navbar-default{background-color:#fff;border-color:#d3e0e9}.navbar-default .navbar-brand{color:#777}.navbar-default .navbar-nav>li>a{color:#777}.navbar-default .navbar-toggle{border-color:#ddd}.navbar-default .navbar-toggle .icon-bar{background-color:#888}.navbar-default .navbar-collapse{border-color:#d3e0e9}.navbar-inverse{background-color:#222;border-color:#090909}.navbar-inverse .navbar-brand{color:#9d9d9d}.navbar-inverse .navbar-nav>li>a{color:#9d9d9d}.navbar-inverse .navbar-toggle{border-color:#333}.navbar-inverse .navbar-toggle .icon-bar{background-color:#fff}.navbar-inverse .navbar-collapse{border-color:#101010}.media{margin-top:15px}.media:first-child{margin-top:0}.media,.media-body{zoom:1;overflow:hidden}.media-body{width:10000px}.media-left{padding-right:10px}.media-body,.media-left{display:table-cell;vertical-align:top}.media-heading{margin-top:0;margin-bottom:5px}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.pull-right{float:right!important}.pull-left{float:left!important}#app{min-height:80vh}body{font-family:Roboto,Helvetica,sans-serif;font-size:16px;background-color:#f7f7ff;font-weight:300;line-height:1.8}.img-responsive{width:100%;height:auto}.b-lazy{max-width:100%;opacity:0}.btn{border-radius:2px}.padded{padding:4em 0}.navbar{margin-bottom:0}.btn.btn-primary{background:-webkit-linear-gradient(#0096ff,#005dff);background:linear-gradient(#0096ff,#005dff);text-shadow:0 1px 1px rgba(0,0,0,.2);border:1px solid rgba(0,0,0,.5)}.thin{font-weight:100!important}.bold{font-weight:700}.text-muted{color:#aaa}.p-content{padding:1em;border:1px solid #eee;border-bottom-left-radius:2px;border-bottom-right-radius:2px;border-top:none;background:#fff;margin-bottom:2em}.p-content h5{margin-top:0;padding-top:0}small{font-size:75%}#hero{padding:3em 0;background:url(/images/hero-back.jpg?7b8647c1687788d61e37e588c7b2644e) repeat-x 50%;position:relative}#hero:before{content:"";position:absolute;background:rgba(0,0,0,.2);top:0;right:0;left:0;bottom:0;z-index:1}#hero div{position:relative;z-index:2;color:#fff}#hero .btn-primary{background:-webkit-linear-gradient(#0096ff,#005dff);background:linear-gradient(#0096ff,#005dff);text-shadow:0 1px 1px rgba(0,0,0,.2);padding:.7em 5em;border:1px solid rgba(0,0,0,.5);letter-spacing:1px}.navbar-inverse .navbar-nav>li>a{color:#eee;font-size:14px}img#logo{width:130px;height:auto}#how{background:#fff}#showcase{padding:2em;padding-bottom:0}#showcase .p-content{margin-bottom:0;border:none;position:absolute;bottom:0;left:0;width:100%;background:rgba(0,0,0,.1)}#showcase .p-content a{color:#fff}#showcase .p-content h5{margin-bottom:0}#showcase .image-wrapper{position:relative;background:#fff}#showcase .portfolio-credit{padding:.5em;background:#fff;border:1px solid #eee;border-top:none;margin-bottom:2em}#showcase .portfolio-credit .media-heading{font-size:12px;margin-top:5px;margin-bottom:0}#showcase .portfolio-credit .media-heading a{opacity:.7;font-weight:700}#showcase .portfolio-credit ul{margin-bottom:0}@media screen and (min-width:540px) and (max-width:768px){.container{width:90%}}@media screen and (min-width:320px) and (max-width:539px){.container{width:90%}}
    </style>
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
        <nav class="navbar navbar-default navbar-static-top navbar-inverse row">
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
                        <img src="data:image/png;base64,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" alt="" class="img-responsive" id="logo">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <!-- <li><a href="{{ route('people') }}">People</a></li> -->
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
            <div class="col-xs-6 col-sm-6 col-md-4">
                <h4>Company Info</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Term of Use</a></li>
                    <li><a href="#">Report Abuse</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASRW46rAvktIC7IsJFva1gKbPKBYlrpQo&libraries=places&region=ng" async></script>
    <script src="{{ asset('js/app.js') }}" async></script>

    <script>
        var inputState = document.getElementById('geolocation');
        if(inputState){
            var options = {
              types: ['(cities)'],
              componentRestrictions: {country: 'ng'}
            };

            autocomplete = new google.maps.places.Autocomplete(inputState, options);
        }

        $('.afix').affix({
            offset: {
                top: 0,
                bottom: function () {
                  return (this.bottom = $('#showcase').outerHeight(true))
                }
            },
            target: window
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" async></script>
    <script>
        // var WebFont = require('webfontloader');
        (function(){
            WebFont.load({
                google: {
                    families: ['Roboto:300,400,700']
                }
            });
        })();
        
    </script>
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
