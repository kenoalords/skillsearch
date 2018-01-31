@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')

<div>
    <div class="hero is-dark">
        <div class="hero-body">
            <div class="columns is-centered">
                <div class="column is-6">
                    <h1 class="title is-3 has-text-centered">Recent Works!</h1>
                    @include('search.people-search-form')
                </div>
            </div>
            
        </div>
    </div>
    <!-- <div class="ui divider" style="padding: .5em 0"></div> -->
    <div class="hero">
        <div class="hero-body">
            <div class="columns is-centered">
                <div class="column is-10">
                    <portfolio-list></portfolio-list>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="padded"></div>
@include('includes.signup-teaser')
@include('includes.skills')

@endsection
