@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    <div class="text-center white-boxed">
    	<img src="{{asset('public/invite.jpg')}}" alt="Invite your friends" style="max-width: 100%">
    </div>
    <div class="container padded">
        <div class="text-center">
            <!-- <h1 class="thin">Invite your friends</h1> -->
            <h4 style="margin-bottom: 2em">Invite your friends from Gmail! It's Fast, Easy and <strong class="text-warning"><i class="fa fa-lock"></i> Safe</strong> to use</h4>
            <div class="col-sm-4 col-sm-offset-4">
	            <p><a href="/invite/gmail" class="btn btn-success btn-block" id="google-invite"><i class="fa fa-google-plus"></i> Invite Friends From Gmail</a></p>
	            
	        </div>
        </div>
    </div>

@endsection