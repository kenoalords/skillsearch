@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Thank You')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    <div class="text-center" style="background: #e0eaec">
        <img src="{{asset('public/thankyou.jpg')}}" alt="Invite your friends" style="max-width: 100%">
    </div>
    <div class="container padded">
        <div class="text-center">
            <h1><i class="fa fa-thumbs-o-up"></i> You Rock!!</h1>
            <p>
                Thank You <strong>{{ session('name') }}</strong>, an invitation email has been sent out to your friends.  
            </p>
            <p>
                <a href="{{ config('app.url') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Home</a>
            </p>
        </div>
    </div>

@endsection