<div>
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