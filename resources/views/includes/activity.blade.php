<div class="media">
	<div class="media-left">
		<a href="{{ $activity['link']['url'] }}" class="">
			<img src="{{ $activity['avatar'] }}" class="thumbnail" width="50" height="50" alt="{{ $activity['fullname'] }}">
		</a>
	</div>
	<div class="media-body">
		<div class="media-heading">
			<strong><a href="{{ $activity['link']['url'] }}" class="">{{ $activity['fullname'] }}</a></strong> 
			{{ $activity['title'] }} <em><small class="text-muted">{{ $activity['date'] }}</small></em>
		</div>
		<div class="media-body">
			@if($activity['type'] === 'avatar')
				<a href="{{ $activity['link']['url'] }}" class="">
					<img src="{{ $activity['avatar'] }}" class="thumbnail" alt="{{ $activity['fullname'] }}" width="100" height="100">
				</a>
			@endif
			
			@if($activity['type'] == 'portfolio')
				<div class="row">
					@include('includes.portfolio-activity', ['portfolio' => $activity['portfolio']])
				</div>
			@endif


			<p></p>
		</div>
	</div>
</div>