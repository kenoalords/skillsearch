@extends('layouts.app')

@section('title', Request::get('term') )
@section('metadescription', 'Find amazing works in ' . Request::get('term') . ' done by skilled people in Nigeria')

@section('content')

<div class="ui centered grid padded">
    <h1 class="ui icon header">
        {{Request::get('term')}} Showcase
    </h1>
</div>
<div class="ui divider"></div>
<div class="ui container padded">
    @if(count($portfolios) > 0)
    <div class="ui centered grid">
        @each('includes.portfolio-with-user', $portfolios, 'portfolio')
    </div>
    @else
    <div class="">
        <h4 class="text-warning">We couldn't find any portfolio item matching your search</h4>
    </div>
    @endif
</div>

@include('includes.skills')

@endsection
