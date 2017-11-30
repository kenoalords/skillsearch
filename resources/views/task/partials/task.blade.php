<div class="item task" id="job-{{$task['id']}}">
	<div class="ui tiny image">
		<img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="ui circular image">
	</div>
	<div class="middle aligned content">
		<!-- <a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a> -->
		<h3 class="header">
			<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="grey-link">
				{{$task['title']}}
			</a>
		</h3>
		<div class="meta">
			<div class="ui horizontal list">
				<a href="#" class="grey item">{{$task['category']}}</a>
				<span class="item">{{$task['location']}}</span>
				@if($task['budget'])
					<span class="item green">
						₦{{ number_format($task['budget']) }} 
						@if($task['budget_type'])
							{{ $task['budget_type'] }}
						@endif
					</span>
				@else
					<span class="item">₦0</span>
				@endif
			</div>
		</div>
		<div class="extra" style="margin-top: 1em">

			@if(Auth::user() && Auth::user()->id === $task['user_id'])
				
				<span>
					@if($task['is_approved'] && !$task['is_rejected'])
						<span class="ui tiny label"><i class="fa fa-check-circle"></i> Approved</span>
					@elseif($task['is_rejected'])
						<span class="ui tiny warning label"><i class="fa fa-close"></i> Rejected</span>
					@else
						<span class="ui tiny warning label"><i class="fa fa-check-circle"></i> Pending</span>
					@endif
					@if($task['closed'] === 1)
						<span class="ui tiny label"><i class="fa fa-lock"></i> Closed</span>
					@endif
				</span>
			@endif
			<span>
				<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}">
					{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
				</a>
			</span>
			@if( $task['application_limit'] > 0 )
				<span>
				@if( $task['application_left'] > 0 )
					<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="text-warning">
						{{ $task['application_left'] }} {{ str_plural( 'Slot', $task['application_left'] ) }} Left
					</a>
				@else
					<span class="text-warning">Application Limit Reached!</span>
				@endif
				</span>
			@endif
			@if(Auth::user() && Auth::user()->id === $task['user_id'])
				<span><a href="{{ route('task_interest', ['task'=>$task['id']]) }}"><i class="fa fa-user"></i> View Applications</a></span>
				@if($task['closed'] !== 1)
				<span><a href="{{ route('edit_task', ['task'=>$task['id']]) }}"><i class="fa fa-pencil-square-o"></i> Edit</a></span>
				<span><a href="{{ route('delete_task', ['task'=>$task['id']]) }}"><i class="fa fa-close"></i> Delete</a></span>
				@endif
			@endif
		</div>
		
	</div>
</div>