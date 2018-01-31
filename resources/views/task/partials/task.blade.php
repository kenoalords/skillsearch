<div class="box is-raised is-radiusless task" id="job-{{$task['id']}}">
	<div class="middle aligned content">
		<!-- <a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a> -->
		<h3 class="title is-4" style="margin-bottom: 0">
			<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="has-text-dark">
				{{$task['title']}}
			</a>
		</h3>
		<div class="level is-mobile">
			<div class="level-left" style="font-size: .875em">
				<a href="#" class="level-item">{{$task['category']}}</a>
				<span class="level-item">{{$task['location']}}</span>
				@if($task['budget'])
					<span class="level-item">
						₦{{ number_format($task['budget']) }} 
						@if($task['budget_type'])
							{{ $task['budget_type'] }}
						@endif
					</span>
				@else
					<span class="level-item">₦0</span>
				@endif
			</div>
		</div>
		<div class="level is-mobile">
			
			<div class="level-left">
				<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="level-item tag is-primary">
					{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
				</a>
				@if( $task['application_limit'] > 0 )
					@if( $task['application_left'] > 0 )
						<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="level-item tag is-primary">
							{{ $task['application_left'] }} {{ str_plural( 'Slot', $task['application_left'] ) }} Left
						</a>
					@else
					<span class="level-item">Application Limit Reached!</span>
					@endif
				@endif
				@if(Auth::user() && Auth::user()->id === $task['user_id'])
					<span class="level-item tag is-primary"><a href="{{ route('task_interest', ['task'=>$task['id']]) }}"><i class="fa fa-user"></i> View Applications</a></span>
					@if($task['closed'] !== 1)
					<span class="level-item tag is-primary"><a href="{{ route('edit_task', ['task'=>$task['id']]) }}"><i class="fa fa-pencil-square-o"></i> Edit</a></span>
					<span class="level-item tag is-primary"><a href="{{ route('delete_task', ['task'=>$task['id']]) }}"><i class="fa fa-close"></i> Delete</a></span>
					@endif
				@endif
			</div>

			<div class="level-right">
				@if(Auth::user() && Auth::user()->id === $task['user_id'])
					@if($task['is_approved'] && !$task['is_rejected'])
						<span class="level-item tag is-primary"><i class="fa fa-check-circle"></i>&nbsp; Approved</span>
					@elseif($task['is_rejected'])
						<span class="level-item tag is-danger"><i class="fa fa-close"></i>&nbsp; Rejected</span>
					@else
						<span class="level-item tag is-danger"><i class="fa fa-check-circle"></i>&nbsp; Pending approval</span>
					@endif
					@if($task['closed'] === 1)
						<span class="level-item tag is-danger"><i class="fa fa-lock"></i>&nbsp; Closed</span>
					@endif
				@endif
			</div>
		</div>
		
	</div>
</div>