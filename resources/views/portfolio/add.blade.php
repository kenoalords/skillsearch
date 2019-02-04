@extends('layouts.dashboard')
@section('title', 'Add Portfolio')
@section('content')


<div class="">
	<h1 class="title is-2 bold">Upload Work</h1>
	<h4 class="subtitle">You can showcase your work in a variety of formats like Video, Audio and Image.</h4>
	<div class="notification is-info"><i class="fa fa-info-circle"></i> <strong>We will feature the best work on our homepage and Instagram page <a href="https://instagram.com/ubanjicreatives" target="_blank">@ubanjicreatives</a> so make it count.</strong></div>
	<portfolio-upload-form user-skills="{{ json_encode($skills) }}"></portfolio-upload-form>
</div>
@endsection
