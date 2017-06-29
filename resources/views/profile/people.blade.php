@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Find People')

@section('content')
 
<div class="container padded">
        
        <h1 class="text-center"><span class="bold">Discover</span> <span class="thin">Amazing Talents in Nigeria</span></h1>   
		
        @include('search-form')
        <hr>
        @if ( count($profiles) )
            <div class="row">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
        @endif
</div>
@if($skills->count())
<div id="categories">
    <div class="container padded">
        <h4 class="bold">Browse top skills</h4>
        <hr>
        @foreach($skills as $skill)
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
            <a href="/search?term={{ urlencode($skill->skill) }}"> {{ $skill->skill }} </a>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
