@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')

    <div class="ui centered container grid">
        <div class="sixteen wide mobile eight wide tablet six wide computer column">
        	<div class="text-center" style="margin-bottom: 2em">
	            <h3>Hi {{ $invitee_name }}</h3>
	            <p>You have used this feature to invite <strong>{{ $invites->count() }}</strong> of your contacts.</p>
				<p>We will notify you once your friends start responding to your invites.</p>
				<p>
	                <a href="{{ config('app.url') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Home</a>
	            </p>
            </div>
        </div>
    </div>

@endsection