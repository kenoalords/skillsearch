<div class="is-hidden-mobile">
    <nav class="navbar is-fixed-top is-transparent" id="primary-nav" role="navigation">
        <div class="container">
            <div class="navbar-brand">
                <!-- Branding Image -->
                <a href="{{ url('/') }}" class="navbar-item">
                    <img src="{{ asset('public/ubanji-logo.png') }}" alt="{{config('app.name')}} Logo">
                </a>
                <a role="button" class="navbar-burger burger" id="app-menu-tigger">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <div class="navbar-item is-expanded">
                        @include('search.people-search-form')
                    </div>
                </div>
                <div class="navbar-end">
                    @if(Auth::user())
                        @include('includes.user-badge')
                    @else
                        <a href="/login" class="navbar-item">Login</a>
                        <a href="/register" class="navbar-item">Register</a>
                    @endif 
                    <div class="navbar-item">
                        <a href="{{ route('new_portfolio') }}" class="button is-info">Upload work</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div> 

<div class="is-flex-mobile is-hidden-desktop">
    <div id="mobile-menu">
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item has-text-left">
                    <a role="button" id="mobile-menu-tigger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('public/ubanji-logo.png') }}" alt="{{config('app.name')}} Logo">
                </a>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="#" class="button is-white" id="search-trigger"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="search-wrapper">
        <div class="container">
            @include('search.people-search-form')
        </div>
    </div>
    <!-- User is not authenticated -->
    <div class="slide-in-menu">
        <div class="close-slide-in-menu"></div>
        <div class="menu">
            @if(Auth::user())
            <div class="user-intro">
                <div class="has-text-centered">
                    <figure class="image is-96x96 is-rounded">
                        <img src="{{ $user['avatar'] }}" alt="{{ $user['fullname'] }}">
                    </figure>
                    <h4 class="title is-5 is-marginless">Hello {{ $user['first_name'] }}</h4>
                    <p style="margin-top: 10px;"><a href="{{ route('edit_profile') }}" class="tag is-info">Edit Profile</a></p>
                </div>
            </div>
            @else
            <div class="user-intro">
                <div class="has-text-centered">
                    <figure class="image is-96x96 is-rounded">
                        <img src="{{asset('public/default-user.jpg')}}" alt="Stranger">
                    </figure>
                    <h4 class="title is-5 is-marginless">Hello Stranger!</h4>
                </div>
            </div>
            @endif
            <ul class="menu-list">
            <li><a href="{{ route('home') }}" class="{{ (Request::path() === '/') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-home"></i></span> <span>Home</span></a></li>
            @if(!Auth::user())
                <li><a href="/login" class="navbar-item"><span class="icon"><i class="fa fa-user"></i></span> <span>Login</span></a></li>
                <li><a href="/register" class="navbar-item"><span class="icon"><i class="fa fa-pencil"></i></span> <span>Sign up</span></a></li>
            @else
                <li><a href="{{ route('dashboard') }}" class="{{ (Request::path() === 'dashboard') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-tachometer"></i></span> <span>Dashboard</span></a></li>
                <li><a href="{{ route('portfolio_index') }}" class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-briefcase"></i></span> <span>Portfolio</span></a></li>
                <li><a href="{{ route('blog') }}" class="{{ (Request::path() == 'dashboard/blog') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-pencil"></i></span> <span>Blog</span></a></li>                

                <li><a href="{{ route('edit_profile') }}" class="{{ (Request::path() == 'dashboard/profile/edit') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-user"></i></span> <span>Profile</span></a></li>

                <li><a href="{{ route('verify_identity') }}" class="{{ (Request::path() == 'dashboard/profile/verify-identity') ? 'is-active' : '' }}"><span class="icon"><i class="fa fa-check"></i></span> <span>Verify Identity <span class="icon verified"></span></span></a></li>
                
                <li><a href="{{ route('gmail_invite') }}"><span class="icon"><i class="fa fa-users"></i></span> <span>Invite Friends</span></a></li>

                <!-- <li><a href="#" class="push-notification"><span class="icon"><i class="fa fa-bell-slash"></i></span> <span>Notifications</span></a></li> -->

                <!-- <li><a href="/dashboard/profile/delete">Delete Account</a></li> -->
                <li><a href="{{ route('logout') }}"><span class="icon"><i class="fa fa-power-off"></i></span> <span>Logout</span></a></li>

                @if(Auth::user()->is_admin === 1)
                    <p class="menu-label">Administrator</p>
                    <ul class="menu-list">
                        <li><a href="{{ route('verify_user_accounts') }}">Verify User Accounts</a></li>
                        <li><a href="{{ route('email_broadcast') }}">Send Email Broadcast</a></li>
                        <li><a href="{{ route('delete_invites') }}">Delete Invite Emails</a></li>
                    </ul>
                @endif
            @endif 

            </ul>
        </div>
    </div>
</div>