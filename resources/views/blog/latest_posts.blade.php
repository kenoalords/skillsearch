
@if ( count($blogs) > 0 )
	<h3 class="title is-4 bold">Latest blog</h3>
	<div class="columns is-multiline">
		@each('blog.partials.blog', $blogs, 'blog')
	</div>
@endif