
@if ( $others )
	<h3 class="title is-4 is-size-5-mobile bold" style="margin-bottom: 1.6em;">{{ $title or 'You might also like' }}</h3>
	<div>
		@each('blog.partials.blog', $others, 'blog')
	</div>
@endif