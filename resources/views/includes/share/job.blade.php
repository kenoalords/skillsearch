<h3 class="ui header">Share</h3>
<div class="ui horizontal list" style="margin-bottom: 2em;">
	<div class="item"><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank" class="ui circular icon facebook button"><i class="icon facebook"></i></a></div>
	<div class="item"><a href="https://twitter.com/home?status={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank" class="ui circular icon twitter button"><i class="icon twitter"></i></a></div>
	<div class="item"><a href="https://plus.google.com/share?url={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank" class="ui circular icon google plus button"><i class="icon google plus"></i></a></div>
</div>