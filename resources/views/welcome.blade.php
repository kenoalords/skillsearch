@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Home')
@section('metadescription', 'Showcase your skills, find latest jobs and get hired on Nigeria preferred skills promotion platform')
@section('content')

<div class="hero is-medium is-dark">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-6">
                <h1 class="title is-2" style="margin-bottom: 1em">
                    Discover and hire creative people
                </h1>
                <h4 class="subtitle is-5">Find the right people for your jobs in Nigeria</h4>
                @include('search.people-search-form') 
            </div>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-body">
        @include('includes.featured-portfolios')
    </div>
</div>


<div class="hero is-primary is-bold">
    <div class="hero-body">
        <h1 class="title has-text-centered">
            Explore Our Marketplace
        </h1>
        <h4 class="subtitle has-text-centered">Find the right people for your next project</h4>
        @include('includes.popular-categories')
    </div>  
</div>

<div class="hero">
    <div class="hero-body">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="columns">
                    <div class="column is-4">
                        <img src="{{ asset('public/job-icon.png') }}" alt="Post a job" class="ui centered image" style="max-width: 200px;">
                    </div>
                    <div class="column is-8">
                        <h2 class="title">Need To Get Work Done Quickly?</h2>
                        <h4 class="subtitle">Find the right team members within seconds</h4>
                        <p>
                            With over 10,000 works showcased on {{config('app.name')}}, finding the right person to join your team or projects has never been easier.
                        </p>
                        <p>
                            <a href="/people" class="button is-primary">Find people</a>
                            <a href="{{ route('create_task') }}" class="button is-primary">Post a job</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    @include('includes.top-users', ['title' => 'Top Members'])
                </div>
            </div>
        </div>
        
    </div>
</div>


@include('includes.signup-teaser')

@include('includes.skills')

@endsection
