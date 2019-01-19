<div class="tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/blog') ? 'is-active' : '' }}">
			<a href="{{ route('blog') }}">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
				<span>Home</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/blog/new') ? 'is-active' : '' }}">
			<a href="{{ route('add_blog') }}">
				<span class="icon">
					<i class="fa fa-pencil"></i>
				</span>
				<span>New post</span>
			</a>
		</li>

		<!-- <li class="{{ (Request::path() == 'dashboard/blog/comments') ? 'is-active' : '' }}">
			<a href="">
				<span class="icon">
					<i class="fa fa-comments"></i>
				</span>
				<span>Comments</span>
			</a>
		</li> -->

		<li class="{{ (Request::path() == 'dashboard/blog/subscribers') ? 'is-active' : '' }}">
			<a href="{{ route('subscribers') }}">
				<span class="icon">
					<i class="fa fa-envelope"></i>
				</span>
				<span>Subscribers</span>
			</a>
		</li>
		
	</ul>
</div>