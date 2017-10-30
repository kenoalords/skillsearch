@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'We want to hear from you, contact '. config('app.name') .' on Twitter @_Ubanji')
@section('title', 'Contact')
@section('content')
	
	<div id="points-header" class="page ui centered grid">
		<h1 class="ui large header">Contact Us</h1>
	</div>
	<div id="page" class="ui centered grid container">
		<div class="fourteen wide mobile eight wide tablet six wide computer column">
			<div class="padded text-center">
				<h3 class="ui header">
					Questions, Comments or Recommendations?
					<p class="sub header">We want to hear from you. Send us a mail <a href="mailto:info@ubanji.com">info[@]ubanji.com</a></p>
				</h3>
				
				<p>Or <a href="https://twitter.com/_ubanji" class="ui twitter button" target="_blank">
					<i class="fa fa-twitter"></i> Tweet <strong>@_Ubanji</strong>
				</a></p>
			</div>
		</div>
	</div>

@endsection