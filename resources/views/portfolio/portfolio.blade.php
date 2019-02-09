@extends('layouts.dashboard')

@section('title', 'My Portfolio')

@section('content')
<div class="">
    @include('includes.status')
    <h1 class="title is-3 is-size-5-mobile bold">Work</h1>
    <h4 class="subtitle is-size-6-mobile">Share your work with the world.</h4>
    @include('portfolio.menu')
    @if ($portfolios)
        <div class="columns is-multiline is-mobile">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>       
        <p><a href="{{ route('new_portfolio') }}" class="button is-info">Upload work</a></p>
    @else
        <div class="notification is-raised is-white is-padded is-bordered-left">
                <h2 class="title is-1 is-size-3-mobile">😎</h2>
                <h3 class="title is-3 is-size-5-mobile bold">Upload your works.</h3>
                <p class="subtitle is-size-6-mobile">Share your creative works start exploring new opportunities</p>
                <p>
                    <a href="{{ route('new_portfolio') }}" class="button is-info big-action-button is-fullwidth-mobile">Start now</a>
                </p>
        </div>
        <div id="dashboard-featured">
            @include('includes.featured-portfolios')
        </div>
    @endif

</div>
@endsection
