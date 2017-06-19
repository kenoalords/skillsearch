<nav class="navbar navbar-default">
    <div class="navbar-header">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
		<ul class="nav navbar-nav">
		    <li><a href="{{ route('tasks') }}"><i class="fa fa-search"></i> Find Jobs</a></li>
		    <li><a href="{{ route('user_jobs') }}" class="{{ $page === 'index' ? 'active bold' : '' }}"><i class="fa fa-briefcase"></i> My Jobs</a></li>
		    <li><a href="{{ route('user_applications') }}" class="{{ $page === 'application' ? 'active bold' : '' }}"><i class="fa fa-pencil"></i> My Applications</a></li>
		    <li><a href="{{ route('saved_task') }}" class="{{ $page === 'saved' ? 'active bold' : '' }}"><i class="fa fa-star"></i> Saved Jobs</a></li>
		</ul>
		<a href="{{ route('add_task') }}" class="btn btn-success btn-sm navbar-btn pull-right"><i class="fa fa-plus"></i> Submit Job</a>
	</div>
</nav>

