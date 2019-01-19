@extends('layouts.dashboard')

@section('title', 'My Portfolio')

@section('content')
<div class="">
    @include('includes.status')
    <h1 class="title is-3">Portfolio</h1>
    <h4 class="subtitle">Share your work with the world.</h4>
    @include('portfolio.menu')
    @if ($portfolios)
        <div class="columns is-multiline is-mobile">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>       
        <p><a href="{{ route('new_portfolio') }}" class="button is-info">Upload work</a></p>
    @else
        <h3 class="title is-4">You have not uploaded any of your work</h3>
        <a href="{{ route('new_portfolio') }}" class="button is-info">
            <span>Upload work</span>
        </a>
    @endif

</div>
@endsection
