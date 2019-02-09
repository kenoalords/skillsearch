<div class="tabs dashboard-menu-tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }}">
			<a href="{{ route('portfolio_index') }}" class="button is-light">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/portfolio/add') ? 'is-active' : '' }}">
			<a href="{{ route('new_portfolio') }}" class="button is-light">
				<span class="icon">
					<i class="fa fa-plus"></i>
				</span>
				<span>New Work</span>
			</a>
		</li>

		<li class="{{ (Request::path() == 'dashboard/portfolio/likes') ? 'is-active' : '' }}">
			<a href="{{ route('portfolio_likes') }}" class="button is-light">
				<span class="icon">
					<i class="fa fa-heart"></i>
				</span>
				<span>Likes</span>
			</a>
		</li>
		
	</ul>
</div>