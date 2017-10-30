<div class="item">
	<a href="{{ $activity['link']['url'] }}" class="ui tiny image">
		<img src="{{ $activity['avatar'] }}" class="" width="50" height="50" alt="{{ $activity['fullname'] }}">
	</a>
	<div class="content">
		<div class="header">
			{{ $activity['fullname'] }}
		</div>
		<div class="deascription">
			{{ $activity['title'] }}
		</div>
	</div>
</div>