@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    <div class="text-center white-boxed" style="padding: 0px">
        <img src="{{asset('public/select-contact.jpg')}}" alt="Invite your friends" style="max-width: 100%">
    </div>
    <div class="container padded">
        <div>
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