<div class="tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }}">
			<a href="{{ route('portfolio_index') }}">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
				<span>&nbsp;</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/portfolio/add') ? 'is-active' : '' }}">
			<a href="{{ route('portfolio_add') }}">
				<span class="icon">
					<i class="fa fa-plus"></i>
				</span>
				<span>Add Portfolio</span>
			</a>
		</li>

		<li class="{{ (Request::path() == 'dashboard/portfolio/likes') ? 'is-active' : '' }}">
			<a href="{{ route('portfolio_likes') }}">
				<span class="icon">
					<i class="fa fa-heart"></i>
				</span>
				<span>Likes</span>
			</a>
		</li>

		<li class="{{ (Request::path() == 'dashboard/portfolio/instagram') ? 'is-active' : '' }}">
			<a href="{{ route('instagram_index') }}">
				<span class="icon">
					<i class="fa fa-instagram"></i>
				</span>
				<span>Instagram</span>
			</a>
		</li>
		
	</ul>
</div>