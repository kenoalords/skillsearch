@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')

    <div class="hero is-medium">
        <div class="hero-body">
        	<div class="columns is-centered">
        		<div class="column is-8">
				<h3 class="title is-2">Hi {{ $invitee_name }}</h3>
				<p>You have used this feature to invite <strong>{{ $invites->count() }}</strong> of your contacts.</p>
				<p>We will notify you once your friends start responding to your invites.</p>
				<p>
					<a href="{{ config('app.url') }}" class="button is-primary"><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Go Home</span></a>
				</p>
        		</div>
	            
            </div>
        </div>
    </div>

@endsection