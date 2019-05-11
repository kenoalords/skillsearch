@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Share your creative works')
@section('metadescription', 'Showcase your photography, graphics design, makeup skills and much more on Ubanji to find new opportunities')
@section('content')

<div class="section" style="background: url({{ asset('images/hero-back.jpg') }}) no-repeat center; background-size: cover">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-10 has-text-centered">
                <h1 class="title is-2 bold is-size-4-mobile has-text-white" style="margin-bottom: 10px">
                    Upload your creative works
                </h1>
                <p class="has-text-white is-size-5">Find new opportunities</p>
                @if( Auth::user() )
                <p>
                    <a href="{{ route('new_portfolio') }}?utm_source=hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Share your work</a>
                </p>
                @else
                <p>
                    <a href="{{ route('register') }}?utm_source=hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Sign up today</a>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- <div class="tabs is-centered is-boxed homepage-tabs">
    <ul>
        <li class="is-active"><a href="javascript:;">Featured</a></li>
        <li><a href="javascript:;">Latest</a></li>
    </ul>
</div> -->
<!-- <div id="tabs">
    <ul>
        <li></li>
        <li><portfolio-list type="latest" :key="2"></portfolio-list></li>
    </ul>
</div> -->
<portfolio-list type="featured"></portfolio-list>
{{-- @include('includes.featured-portfolios') --}}

@include('includes.signup-teaser')

<section class="section is-white">
    <div class="container">
        @include('blog.latest_posts')
    </div>
</section>

@include('includes.skills')

@endsection
