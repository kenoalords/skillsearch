@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'We want to hear from you, contact '. config('app.name') .' on Twitter @SkillsearchNG')
@section('title', 'Contact')
@section('content')
	
	<div id="points-header" class="page padded text-center">
		<h1 class="bold">Contact Us</h1>
	</div>
	<div id="page" class="container">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="padded text-center">
				<h3>Questions, Comments or Recommendations?</h3>
				<p>We want to hear from you. Send us a mail <a href="mailto:info@skillsearch.com.ng">info[@]skillsearch.com.ng</a></p>
				<p>Or <a href="https://twitter.com/skillsearchng" class="btn btn-default" target="_blank">
					<i class="fa fa-twitter"></i> Tweet <strong>@SkillsearchNG</strong>
				</a></p>
			</div>
		</div>
	</div>

@endsection