@extends('layouts.admin')
@section('title', 'Edit Portfolio')
@section('content')
<div class="padded">
	<portfolio-form portfolio="{{ $portfolio }}" files="{{ $files }}" skills="{{ $skills }}"></portfolio-form>
</div>
@endsection
