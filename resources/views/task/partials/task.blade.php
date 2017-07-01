<div class="job" id="job-{{$task['id']}}">
	<div class="container-fluid">
		<div>
			@if(Auth::user() && Auth::user()->id === $task['user_id'])
				@if($task['is_approved'] && !$task['is_rejected'])
					<span class="label label-primary"><i class="fa fa-check-circle"></i> Approved</span>
				@elseif($task['is_rejected'])
					<span class="label label-danger"><i class="fa fa-close"></i> Rejected</span>
				@else
					<span class="label label-warning"><i class="fa fa-check-circle"></i> Pending</span>
				@endif
				@if($task['closed'] === 1)
					<span class="label label-success"><i class="fa fa-lock"></i> Closed</span>
				@endif
			@endif
			<h3 style="line-height: 1.7" class="bold job-title">
				<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}">
					{{$task['title']}}
				</a>
			</h3>
			<ul class="list-inline" style="font-size: .875em">
				<li>
					<img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="img-circle" width="18" height="18"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span>
				</li>
				<li>in <a href="#" class="bold">{{$task['category']}}</a></li>
				<li class="bold"><i class="fa fa-map-marker"></i> {{$task['location']}}</li>
				<li>{{$task['date']}}</li>
				@if($task['budget'])
					<li class="pull-right text-right">
						<span class="text-warning bold budget">₦{{ number_format($task['budget']) }}</span>
						@if($task['budget_type'])
							<span style="display: block; font-size: .875em" class="bold">{{ $task['budget_type'] }}</span>
						@endif
					</li>
				@else
					<li class="pull-right text-right">
						<span class="text-warning bold budget">₦0</span>
					</li>
				@endif
				@if($task['expires_at'])
		            <li class="bold text-warning">Expires {{ $task['expires_human'] }}</li>
		        @endif
			</ul>
			<p>
				{{ str_limit($task['description'], 100) }}
			</p>
			<ul class="list-inline">
				<li class="bold">
					<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}">
						{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
					</a>
				</li>
				@if( $task['application_limit'] > 0 )
					<li class="bold">
					@if( $task['application_left'] > 0 )
						<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="text-warning">
							{{ $task['application_left'] }} {{ str_plural( 'Slot', $task['application_left'] ) }} Left
						</a>
					@else
						<span class="text-warning">Application Limit Reached!</span>
					@endif
					</li>
				@endif
				@if(Auth::user() && Auth::user()->id === $task['user_id'])
					<li><a href="{{ route('task_interest', ['task'=>$task['id']]) }}"><i class="fa fa-user"></i> View Applications</a></li>
					@if($task['closed'] !== 1)
					<li><a href="{{ route('edit_task', ['task'=>$task['id']]) }}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
					<li class="pull-right"><a href="{{ route('delete_task', ['task'=>$task['id']]) }}"><i class="fa fa-close"></i> Delete</a></li>
					@endif
				@endif
			</ul>

		</div>
		
	</div>
	
</div>