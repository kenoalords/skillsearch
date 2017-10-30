@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
<div class="ui container">
    <div class="ui centered grid">
        <img src="{{asset('public/invite.jpg')}}" alt="Invite your friends" style="max-width: 100%">
        <div class="padded">
            <h3 class="ui header" style="margin-bottom: 2em">Invite your friends from Gmail! It's Fast, Easy and <strong class="ui green text"><i class="icon lock"></i>Safe</strong> to use</h3>
            <p><a href="/invite/gmail" class="ui icon labeled google plus button" id="google-invite"><i class="icon google plus"></i> Invite Friends From Gmail</a></p>
        </div>
    </div>
</div>
@endsection