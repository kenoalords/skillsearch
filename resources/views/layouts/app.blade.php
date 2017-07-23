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


    <title>@yield('title') - {{ config('app.name', 'Skillsearch Nigeria') }} | {{ config('app.description') }}</title>
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
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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
        <nav class="navbar navbar-default navbar-fixed-top container-fluid" id="primary-nav">
            <div class="container">
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
                        <img src="data:image/png;base64,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" alt="{{config('app.name')}} Logo" class="img-responsive" id="logo">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    

                    <!-- <form action="/search" method="get" class="navbar-left navbar-form hidden-sm" id="navbar-search-form">
                        <div class="input-group">
                            <input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>    
                    </form> -->

                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('people') }}">People</a></li>
                        <li><a href="{{ route('work') }}">Portfolio</a></li>
                        <li><a href="{{ route('tasks') }}">Jobs</a></li>
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
                                    {{ ucwords(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/home">My Account</a>
                                        <a href="{{ route('requests') }}">Messages</a>
                                        <a href="/profile/portfolio">Portfolio</a>
                                        <a href="/profile/portfolio/instagram">Instagram Feed</a>
                                        <a href="{{ route('user_jobs') }}">Jobs</a>
                                        @if(Auth::user()->is_admin === 1)
                                            <a href="{{ route('verify_user_accounts') }}">Verify User Accounts</a>
                                            <a href="{{ route('approve_jobs') }}">
                                                Job Approval
                                            </a>
                                            <a href="{{ route('linkedin_contacts') }}">
                                                Linkedin Contacts
                                            </a>
                                            <a href="{{ route('delete_invites') }}">Manage Invites</a>
                                        @endif
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
                        <!-- <li>
                            <a href="/jobs/submit" class="btn btn-default navbar-btn">
                                 Promote Your Work
                            </a>
                        </li> -->
                        <li>
                            <a href="/jobs/submit" class="btn btn-success navbar-btn">
                                 Submit Your Job
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- <section id="invites">
        <div class="container text-center">
            <h4 class="thin"><a href="/invite" class="btn btn-success"><i class="fa fa-heart"></i> Invite your friends</a></h4>
        </div>
    </section> -->

    <footer id="site-footer" class="padded">
        <div class="container" id="sub-footer">
            <div class="col-xs-6 col-sm-6 col-md-4">
                <h4>About</h4>
                <ul>
                    <li><a href="/about">Us</a></li>
                    <li><a href="/how-it-works">How It Works</a></li>
                    <li><a href="/points">Points</a></li>
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
                
                <p class="text-center" id="social-links">
                    <a href="https://www.facebook.com/skillsearchng/" target="_blank"><i class="fa fa-facebook-square"></i></a>
                    <a href="https://twitter.com/skillsearchng"><i class="fa fa-twitter"></i></a>
                </p>
                <div class="text-center bold text-muted" style="letter-spacing: 1px">
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

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" async></script>
    <!-- <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script> -->
    <!-- <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script> -->
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
