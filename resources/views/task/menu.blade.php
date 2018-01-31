<div class="tabs">
	<ul>
		<li class="{{ (Request::path() == 'dashboard/jobs') ? 'is-active' : '' }}">
			<a href="{{ route('user_jobs') }}">
				<span class="icon">
					<i class="fa fa-home"></i>
				</span>
				<span>&nbsp;</span>
			</a>
		</li>
		<li class="{{ (Request::path() == 'dashboard/jobs/add') ? 'is-active' : '' }}">
			<a href="{{ route('add_task') }}">
				<span class="icon">
					<i class="fa fa-plus"></i>
				</span>
				<span>Add Job</span>
			</a>
		</li>

		<li class="{{ (Request::path() == 'dashboard/jobs/applications') ? 'is-active' : '' }}">
			<a href="{{ route('user_applications') }}">
				<span class="icon">
					<i class="fa fa-file-text"></i>
				</span>
				<span>Applications</span>
			</a>
		</li>

		<li class="{{ (Request::path() == 'dashboard/jobs/saved') ? 'is-active' : '' }}">
			<a href="{{ route('saved_task') }}">
				<span class="icon">
					<i class="fa fa-star"></i>
				</span>
				<span>Saved</span>
			</a>
		</li>
		
	</ul>
</div>