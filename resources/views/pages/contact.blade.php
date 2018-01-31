@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'We want to hear from you, contact '. config('app.name') .' on Twitter @ubanjicreatives')
@section('title', 'Contact')
@section('content')

<h1 class="title">Contact Us</h1>
<h3 class="title is-4">
	Questions, Comments or Recommendations?
</h3>
<p>We want to hear from you. Send us a mail <a href="mailto:info@ubanji.com">info[@]ubanji.com</a></p>

<p><a href="https://twitter.com/ubanjicreatives" class="button is-info" target="_blank">
	<span class="icon"><i class="fa fa-twitter"></i></span> <span>Tweet <strong>@ubanjicreatives</strong></span>
</a></p>

@endsection