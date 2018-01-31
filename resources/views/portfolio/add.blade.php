@extends('layouts.dashboard')
@section('title', 'Add Portfolio')
@section('content')


<div class="">
	<h1 class="title is-3">Upload Work</h1>
	<portfolio-upload-form user-skills="{{ json_encode($skills) }}"></portfolio-upload-form>
</div>

@endsection
