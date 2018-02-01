@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Unsubscribe')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
    
    <div class="hero is-medium">
        <div class="hero-body has-text-centered">
        	<div class="text-center" style="margin-bottom: 2em">
        		<h3 class="title is-4">{{$email}} Successfully Removed!</h3>
	            <p>You will no longer receive reminder emails to join {{config('app.name')}}</p>
	            <p><a href="{{config('app.url')}}" class="button is-primary">Back to {{config('app.name')}}</a></p>
            </div>
        </div>
    </div>

@endsection