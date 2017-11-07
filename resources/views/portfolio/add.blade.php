@extends('layouts.admin')
@section('title', 'Add Portfolio')
@section('content')


<div class="padded">
	<portfolio-form skills="{{$skills}}" name="{{ $name }}"></portfolio-form>
</div>

@endsection
