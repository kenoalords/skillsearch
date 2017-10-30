@extends('layouts.user')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Unsubscribe')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
    
<h3 class="thin">Hmmm!, {{$email}} Not Found</h3>
<p>We couldn't find the your email in our awesome list. We are quite certain you have opted out before.</p>
<p><a href="{{config('app.url')}}" class="ui green icon labeled fluid button"><i class="icon arrow left"></i>Back to {{config('app.name')}}</a></p>

@endsection