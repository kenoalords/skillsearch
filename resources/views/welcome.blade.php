@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Share your creative works')
@section('metadescription', 'Showcase your photography, graphics design, makeup skills and much more on Ubanji to find new opportunities')
@section('content')

<div class="section" style="background: url({{ asset('images/how-banner-2.jpg') }}) no-repeat center; background-size: cover">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-10 has-text-centered">
                <h1 class="title is-2 bold has-text-white" style="margin-bottom: 0em">
                    Share your creative works
                </h1>
                <p class="has-text-white is-size-5">Find new opportunities</p>
                <p>
                    <a href="#" class="button is-primary big-action-button">Get started</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="tabs is-centered is-boxed homepage-tabs">
    <ul>
        <li class="is-active"><a href="javascript:;">Featured</a></li>
        <li><a href="javascript:;">Latest</a></li>
    </ul>
</div>
<div id="tabs">
    <ul>
        <li><portfolio-list type="featured" :key="1"></portfolio-list></li>
        <li><portfolio-list type="latest" :key="2"></portfolio-list></li>
    </ul>
</div>
{{-- @include('includes.featured-portfolios') --}}

@include('includes.signup-teaser')

<section class="section is-white">
    <div class="container">
        @include('blog.latest_posts')
    </div>
</section>

@include('includes.skills')

@endsection
