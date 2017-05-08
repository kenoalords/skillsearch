@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Unsubscribe')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    
    <div class="container padded">
        <div>
        	<div class="text-center" style="margin-bottom: 2em">
        		<h3 class="thin">Hmmm!, {{$email}} Not Found</h3>
	            <p>We couldn't find the your email in our awesome list. We are quite certain you have opted out before.</p>
	            <p><a href="{{config('app.url')}}" class="btn btn-success">Back to {{config('app.name')}}</a></p>
            </div>
        </div>
    </div>

@endsection