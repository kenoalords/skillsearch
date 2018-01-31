@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how '.config('app.name').' can help promote your works and get you hired!')
@section('title', 'Privacy Policy')

@section('content')
	
<h1 class="title">Privacy</h1>

<p>Your privacy is critically important to us. At {{config('app.name')}} we have a few fundamental principles</p>
			
<ol style="font-size: 16px; line-height: 1.7">
	<li style="margin-bottom: 1em">We don’t ask you for personal information unless we truly need it. (We can’t stand services that ask you for things like your debit card details or income level for no apparent reason.)</li>
	<li style="margin-bottom: 1em">We don’t share your personal information with anyone except to comply with the law, develop our products, or protect our rights.</li>
	<li style="margin-bottom: 1em">We don’t store personal information on our servers unless required for the on-going operation of one of our services.</li>
</ol>	

@endsection