@extends('layouts.admin')
@section('title', 'Email Broadcast')
@section('content')

<h1 class="ui header">
	Send email broadcast
	<div class="sub header">You can send a general broadcast to all members</div>
</h1>
<div class="ui divider"></div>
<form action="#" class="ui form" method="post">
	{{ csrf_field() }}
	<div class="field">
		<label>Subject</label>
		<input type="text" name="subject">
	</div>
	<div class="field">
		<label for="">Image Link</label>
		<input type="text" name="image_link" placeholder="http://example.com/image.jpg">
	</div>
	<div class="field">
		<label>Body</label>
		<textarea name="body" rows="10"></textarea>
		<div class="ui list">
			<div class="item">
				Image: ![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")
			</div>
			<div class="item">
				Link: [I'm an inline-style link](https://www.google.com)
			</div>
			<div class="item">
				<h4 class="ui header">Headers:</h4>
				# H1 <br>
				## H2<br>
				### H3<br>
			</div>
		</div>
		<p><a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Click here for markdown cheat sheet</a></p>
	</div>
	<div class="field">
		<label for="">Action Link</label>
		<input type="text" name="url" placeholder="http://example.com">
	</div>
	<div class="field">
		<label for="">Button Text</label>
		<input type="text" name="button_text" placeholder="e.g. Learn more">
	</div>
	<div class="field">
		<button type="submit" class="ui primary button">Send Broadcast</button>
	</div>
	
</form>

@endsection
