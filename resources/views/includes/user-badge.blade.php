<div class="navbar-item has-dropdown is-hoverable">
	<a class="navbar-link" href="/dashboard">
		<span class="user-badge">
			<img src="{{ $user['avatar'] }}" alt="{{ $user['username'] }}" class="image is-rounded is-inline is-borderless is-user-profile">
		</span>
	</a>
	<div class="navbar-dropdown">
		<a href="/dashboard" class="{{ (Request::path() == 'dashboard') ? 'is-active' : '' }} navbar-item">Dashboard</a>
		<a href="/dashboard/portfolio" class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }} navbar-item">Portfolio</a>
		<a href="{{ route('user_jobs') }}" class="navbar-item {{ (Request::path() == 'dashboard/jobs') ? 'is-active' : '' }}">Jobs</a>
		<!-- <a href="{{ route('user_gigs') }}" class="navbar-item {{ (Request::path() == 'dashboard/gigs') ? 'is-active' : '' }}">Gigs</a> -->
		<a href="{{ route('edit_profile') }}" class="navbar-item {{ (Request::path() == 'dashboard/profile/edit') ? 'is-active' : '' }}">Profile</a>
		<hr class="navbar-divider">
		<a href="/logout" class="navbar-item">Logout</a>
	</div>
</div>