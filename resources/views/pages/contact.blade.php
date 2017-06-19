@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'We want to hear from you, contact Skillsearch Nigeria on Twitter @SkillsearchNG')

@section('content')
	
	<div id="hero" class="page padded text-center">
		<h1>Contact Us</h1>
	</div>
	<div id="page" class="container">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="padded text-center">
				<p><strong>Questions, Comments or Concerns?</strong></p>
				<p>We want to hear from you. Send us a mail <a href="mailto:info@skillsearch.com.ng">info@skillsearch.com.ng</a></p>
				<p>OR</p>
				<p><a href="https://twitter.com/skillsearchng" class="btn btn-primary" target="_blank">
					<i class="fa fa-twitter"></i> Tweet <strong>@SkillsearchNG</strong>
				</a></p>
			</div>
		</div>
	</div>

@endsection