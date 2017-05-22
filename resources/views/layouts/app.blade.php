<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scaleable=no">

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
    
    <!-- Styles -->
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
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top navbar-inverse container-fluid">
            <div class="">
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
                    

                    <form action="/search" method="get" class="navbar-left navbar-form hidden-sm" id="navbar-search-form">
                        <div class="input-group">
                            <input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>    
                    </form>

                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('people') }}">Find People</a></li>
                        <li><a href="{{ route('work') }}">Recent Works</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right" style="margin-right: 0">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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
                        @endif
                        <li>
                            <a href="/profile/portfolio/add" class="btn btn-primary navbar-btn">
                                <i class="fa fa-briefcase"></i> Submit Your Work
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <section id="invites">
        <div class="container text-center">
            <h4 class="thin"><a href="/invite" class="btn btn-success"><i class="fa fa-heart"></i> Invite your friends</a></h4>
        </div>
    </section>

    <footer id="site-footer" class="padded">
        <div class="container" id="sub-footer">
            <div class="col-xs-6 col-sm-6 col-md-4">
                <h4>Company Info</h4>
                <ul>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/how-it-works">How It Works</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <h4>Legal</h4>
                <ul>
                    <li><a href="/privacy">Privacy Policy</a></li>
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
                    If you discover any copyright infringement or illegalities, <a href="/contact">kindly contact us.</a>
                </p>
            </div>
        </div>

        <div class="container text-center">
            <hr>
            <div class="clearfix">
                <ul class="list-inline pull-left" id="social-links">
                    <li><a href="https://www.facebook.com/skillsearchng/" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                    <li><a href="https://twitter.com/skillsearchng"><i class="fa fa-twitter"></i></a></li>
                    <!-- <li><a href="https://plus.google.com/skillsearchng"><i class="fa fa-google-plus-square"></i></a></li> -->
                </ul>
                <div class="pull-right">
                    <small>Skillsearch Nigeria &copy; Copyright <?php echo date('Y') ?> a <a href="http://clickmedia.com.ng" target="_blank">Clickmedia Solutions Project</a></small>
                </div>
            </div>
            
            
        </div>
    </footer>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
    
    
    
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
        var WebFont = require('webfontloader');
        (function(){
            WebFont.load({
                google: {
                    families: ['Lato:300,400,700']
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
