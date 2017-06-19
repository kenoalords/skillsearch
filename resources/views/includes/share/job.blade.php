<h5 class="bold"><i class="fa fa-share-alt"></i> Share</h5>
<ul class="list-inline share-links" style="margin-bottom: 2em;">
	<li><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
	<li><a href="https://twitter.com/home?status={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
	<li><a href="https://plus.google.com/share?url={{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
</ul>