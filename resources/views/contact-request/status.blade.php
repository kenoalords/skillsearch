@extends('layouts.user')

@section('title', 'Contact Request Sent')

@section('content')

@if(Request::get('status') === 'sent')
<h4 class="ui medium header">{{Request::get('sender')}}, your request has been sent to {{Request::get('name')}}</h4>
<p>We will notify you once your request is approved.</p>
@else
<p>Oops! Something is not right</p>
@endif
<a href="{{ route('view_profile', ['user'=>Request::get('user')]) }}" class="ui primary fluid button">Back to profile</a>
@endsection
