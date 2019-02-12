<div class="column is-one-third-desktop is-half-tablet">
	<div class="blog-excerpt is-raised">
	<figure class="image" style="background: url({{ $blog['image'] }}) no-repeat center #ddd; background-size: cover;">
		<a href="{{ $blog['url'] }}">
			<img src="{{ $blog['image'] }}" alt="{{$blog['title']}}">
		</a>
	</figure>
	<div class="blog-card">
		<div class="meta">
			<div class="level is-mobile">
				<div class="level-left">
					<div class="level-item">
						<a href="{{ route('view_profile', ['user'=>$blog['profile']['username']]) }}" class="avatar small">
							<img src="{{ $blog['profile']['avatar'] }}" alt="{{ $blog['profile']['fullname'] }}"><span itemprop="author" class="{{ ($blog['profile']['verified']) ? 'verified' : '' }} author" ></span>
						</a>
					</div>
					<div class="level-item">
						<a href="#" class="tag is-light">{{ $blog['category'] }}</a>
					</div>
					<div class="level-item">
						<span>{{ $blog['date']['created_at'] }}</span>
					</div>
				</div>
				<div class="level-right">
					<div class="level-item">
						<span class="icon"><i class="fa fa-thumbs-up"></i></span> {{ $blog['likes']['count'] }}
					</div>
					<div class="level-item">
						<span class="icon"><i class="fa fa-comments"></i></span> {{ $blog['comment_count'] }}
					</div>
				</div>
			</div>
		</div>
		<hr style="margin: 0 0 10px 0; opacity: .4">
		<h2 class="title is-5 is-size-6-mobile">
			<a href="{{ $blog['url'] }}">
				{{$blog['title']}}
			</a>
		</h2>
		@if ( Auth::user() && Auth::user()->id == $blog['user_id'] && Request::path() == 'dashboard/blog' )
			<div class="level is-mobile user-links">
				<div class="level-left">
					<div class="level-item">
						<a href="{{ route('edit_blog', ['blog'=>$blog['id']]) }}">Edit</a>
					</div>
					<div class="level-item">
						<a href="javascript:;" class="has-text-danger delete-blog" data-id="{{ $blog['id'] }}">Delete</a>
					</div>
				</div>
				<div class="level-right">
					
				</div>
			</div>
		@endif
	</div>
	</div>
</div>