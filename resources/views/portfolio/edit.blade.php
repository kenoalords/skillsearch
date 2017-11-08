@extends('layouts.admin')
@section('title', 'Edit Portfolio')
@section('content')
<div class="padded">
	<portfolio-upload-form portfolio="{{ json_encode($portfolio) }}" user-skills="{{ json_encode($skills) }}"></portfolio-upload-form>
</div>
@endsection
