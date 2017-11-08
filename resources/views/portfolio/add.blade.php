@extends('layouts.admin')
@section('title', 'Add Portfolio')
@section('content')


<div class="padded">
	<portfolio-upload-form user-skills="{{ json_encode($skills) }}"></portfolio-upload-form>
</div>

@endsection
