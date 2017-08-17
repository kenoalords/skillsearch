<div class="blog-s">
	<h2 class="blog-title">
		<a href="{{ route('blog', ['blog'=> $blog['uid'], 'user'=>$blog['profile']['username'], 'slug' => $blog['slug']]) }}">
			{{$blog['title']}}
		</a>
	</h2>
	<h5 class="text-muted">{{ $blog['date']['created_human'] }}</h5>
	<p>
		@if($blog['excerpt'] !== null)
			{!! str_limit($blog['excerpt'], 160) !!}
		@else
			{!! str_limit($blog['body'], 160) !!}
		@endif
	</p>
	<ul class="list-inline clearfix bold blog-meta">
		<li><i class="fa fa-thumbs-up"></i> {{ $blog['likes']['count'] }}</li>
		<li><i class="fa fa-comments"></i> {{ $blog['comment_count'] }}</li>
		@if(Auth::user() && Auth::user()->id === $blog['user_id'])
			<li class="pull-right"><a href="/profile/blog/{{ $blog['uid'] }}/edit"><i class="fa fa-pencil"></i> Edit</a></li>
		@endif
	</ul>
</div>