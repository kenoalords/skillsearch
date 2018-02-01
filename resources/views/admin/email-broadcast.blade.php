@extends('layouts.dashboard')
@section('title', 'Email Broadcast')
@section('content')

<h1 class="title is-2">
	Send email broadcast
</h1>
<p class="sub header">You can send a general broadcast to all members</p>

<form action="#" method="post">
	{{ csrf_field() }}
	<div class="field">
		<label>Subject</label>
		<input type="text" name="subject" class="input">
	</div>
	<div class="field">
		<label for="">Image Link</label>
		<input type="text" name="image_link" placeholder="http://example.com/image.jpg" class="input">
	</div>
	<div class="field">
		<label>Body</label>
		<textarea name="body" rows="10" class="textarea"></textarea>
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
		<input type="text" name="url" placeholder="http://example.com" class="input">
	</div>
	<div class="field">
		<label for="">Button Text</label>
		<input type="text" name="button_text" placeholder="e.g. Learn more" class="input">
	</div>
	<div class="field">
		<button type="submit" class="is-primary button">Send Broadcast</button>
	</div>
</form>

@endsection
