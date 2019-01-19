<div class="navbar-item has-dropdown is-hoverable">
	<a class="navbar-link" href="/dashboard">
		<span class="user-badge">
			<img src="{{ $user['avatar'] }}" alt="{{ $user['username'] }}" class="image is-rounded is-inline is-borderless is-user-profile">
		</span>
	</a>
	<div class="navbar-dropdown">
		<a href="{{ route('dashboard') }}" class="{{ (Request::path() == 'dashboard') ? 'is-active' : '' }} navbar-item">Dashboard</a>
		<a href="{{ route('portfolio_index') }}" class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }} navbar-item">Portfolio</a>
		<a href="{{ route('blog') }}" class="navbar-item {{ (Request::path() == 'dashboard/blog') ? 'is-active' : '' }}">Blog</a>
		<!-- <a href="{{ route('user_gigs') }}" class="navbar-item {{ (Request::path() == 'dashboard/gigs') ? 'is-active' : '' }}">Gigs</a> -->
		<a href="{{ route('edit_profile') }}" class="navbar-item {{ (Request::path() == 'dashboard/profile/edit') ? 'is-active' : '' }}">Profile</a>
		<hr class="navbar-divider">
		<a href="{{ route('logout') }}" class="navbar-item">Logout</a>
	</div>
</div>