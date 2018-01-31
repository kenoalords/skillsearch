<div class="tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/gigs') ? 'is-active' : '' }}">
			<a href="{{ route('user_gigs') }}">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
				<span>&nbsp;</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/gigs/add') ? 'is-active' : '' }}">
			<a href="{{ route('add_gig') }}">
				<span class="icon">
					<i class="fa fa-plus"></i>
				</span>
				<span>Add Gig</span>
			</a>
		</li>
	</ul>
</div>