@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Find People')

@section('content')
 
<div class="ui row">
        <section class="hero is-dark">
            <div class="hero-body">
                <div class="columns is-centered">
                    <div class="column is-6 has-text-centered">
                        <h1 class="title is-3">
                            Search Great Talents
                        </h1>  
                        <div class="subtitle is-6">Find the right people for your job in Nigeria.</div>
                        @include('search.people-search-form') 
                    </div>
                </div>
                
            </div>           
        </section>

        @if ( count($profiles) )
            <div class="hero">
                <div class="hero-body">
                    <div class="columns is-centered">
                        <div class="column is-10">
                            <div class="columns is-multiline">
                                @each('profile.person', $profiles, 'profile')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        @endif

        <div class="hero is-primary is-bold">
            <div class="hero-body">
                <h1 class="title has-text-centered">
                    Explore Our Marketplace
                </h1>
                <h4 class="subtitle has-text-centered">Find the right people for your next project</h4>
                @include('includes.popular-categories')
            </div>  
        </div>

</div>
@include('includes.signup-teaser')

@include('includes.skills')

@endsection
