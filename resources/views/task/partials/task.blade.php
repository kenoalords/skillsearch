<div class="item" id="job-{{$task['id']}}">
	<div class="">
		<div>
			
			<h3 class="ui grey header">
				<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="grey-link">
					{{$task['title']}}
				</a>
			</h3>
			<div class="ui tiny grey horizontal list" style="margin-top: 0">
				<div class="item">
					<img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="ui avatar image" width="18" height="18"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span>
				</div>
				<div class="item">in <a href="#" class="bold">{{$task['category']}}</a></div>
				<div class="item"><i class="icon marker"></i> {{$task['location']}}</div>
				<div class="item">{{$task['date']}}</div>
				
				@if($task['expires_at'])
		            <div class="item">Expires {{ $task['expires_human'] }}</div>
		        @endif
			</div>
			
			<p>
				{{ str_limit($task['description'], 150) }}
			</p>
			<div class="ui horizontal list">
				@if($task['budget'])
					<div class="item">
						<span class="ui large red header">
							₦{{ number_format($task['budget']) }}
							@if($task['budget_type'])
								<span class="sub header">{{ $task['budget_type'] }}</span>
							@endif
						</span>
						
					</div>
				@else
					<div class="item">
						<span class="ui red large header">₦0</span>
					</div>
				@endif
				@if(Auth::user() && Auth::user()->id === $task['user_id'])
					
					<div class="item">
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
					</div>
				@endif
				<div class="item">
					<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}">
						{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
					</a>
				</div>
				@if( $task['application_limit'] > 0 )
					<div class="item">
					@if( $task['application_left'] > 0 )
						<a href="{{ route('task', [ 'task'=>$task['id'], 'slug'=>$task['slug'] ]) }}" class="text-warning">
							{{ $task['application_left'] }} {{ str_plural( 'Slot', $task['application_left'] ) }} Left
						</a>
					@else
						<span class="text-warning">Application Limit Reached!</span>
					@endif
					</div>
				@endif
				@if(Auth::user() && Auth::user()->id === $task['user_id'])
					<div class="item"><a href="{{ route('task_interest', ['task'=>$task['id']]) }}"><i class="fa fa-user"></i> View Applications</a></div>
					@if($task['closed'] !== 1)
					<div class="item"><a href="{{ route('edit_task', ['task'=>$task['id']]) }}"><i class="fa fa-pencil-square-o"></i> Edit</a></div>
					<div class="item"><a href="{{ route('delete_task', ['task'=>$task['id']]) }}"><i class="fa fa-close"></i> Delete</a></div>
					@endif
				@endif
			</div>
			
		</div>
		
	</div>
	
</div>