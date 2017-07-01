@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how Skillsearch Nigeria can help promote your works and get you hired!')
@section('title', 'Privacy Policy')

@section('content')
	
	<div id="points-header" class="page padded text-center">
		<h1 class="bold">Privacy</h1>
	</div>
    <div id="page" class="container padded">
    	<div class="col-sm-8 col-sm-offset-2 padded">
    		<p>Your privacy is critically important to us. At {{config('app.name')}} we have a few fundamental principles</p>
			
			<ol style="font-size: 16px; line-height: 1.7">
				<li style="margin-bottom: 1em">We don’t ask you for personal information unless we truly need it. (We can’t stand services that ask you for things like your debit card details or income level for no apparent reason.)</li>
				<li style="margin-bottom: 1em">We don’t share your personal information with anyone except to comply with the law, develop our products, or protect our rights.</li>
				<li style="margin-bottom: 1em">We don’t store personal information on our servers unless required for the on-going operation of one of our services.</li>
			</ol>			
	    </div>
	</div>

@endsection