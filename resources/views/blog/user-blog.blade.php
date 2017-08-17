@extends('layouts.app')

@section('content')


<div style="background: #fff; margin-top: 5em">
<div class="container padded">
	<div class="col-md-10 col-md-offset-1">
		@if(count($blogs) > 0)
            @each('blog.partials.blog', $blogs, 'blog')
        @endif
	</div>
    
</div>
</div>
@endsection
