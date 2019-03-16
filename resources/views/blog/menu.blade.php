<div class="tabs dashboard-menu-tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/blog') ? 'is-active' : '' }}">
			<a href="{{ route('blog') }}" class="button is-info">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/blog/new') ? 'is-active' : '' }}">
			<a href="{{ route('add_blog') }}" class="button is-info">
				<span class="icon">
					<i class="fa fa-pencil"></i>
				</span>
				<span>New Post</span>
			</a>
		</li>

		<!-- <li class="{{ (Request::path() == 'dashboard/blog/comments') ? 'is-active' : '' }}">
			<a href="" class="button">
				<span class="icon">
					<i class="fa fa-comments"></i>
				</span>
				<span>Comments</span>
			</a>
		</li> -->

		<li class="{{ (Request::path() == 'dashboard/blog/subscribers') ? 'is-active' : '' }}">
			<a href="{{ route('subscribers') }}" class="button is-info">
				<span class="icon">
					<i class="fa fa-envelope"></i>
				</span>
				<span>Subscribers</span>
			</a>
		</li>
		
	</ul>
</div>