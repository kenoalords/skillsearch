@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Thank You')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
    <div class="hero is-medium">
        <div class="hero-body has-text-centered">
            <h1 class="title is-3">
                <span class="icon"><i class="fa fa-thumbs-o-up"></i></span> 
                <span>You Rock!!</span>
            </h1>
            <p>
                Thank You <strong>{{ session('name') }}</strong>, an invitation email has been sent out to your friends.  
            </p>
            <p>
                <a href="{{ config('app.url') }}" class="button is-primary is-raised">
                    <span class="icon"><i class="fa fa-arrow-left"></i></span> 
                    <span>Go Home</span>
                </a>
            </p>
        </div>
    </div>

@endsection