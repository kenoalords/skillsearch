@extends('layouts.app')

@section('title', Request::get('term') )
@section('metadescription', 'Find amazing works in ' . Request::get('term') . ' done by skilled people in Nigeria')

@section('content')

<div id="points-header">
    <h1 class="thin medium-header text-center">Portfolios in <span class="bold">{{Request::get('term')}}</span></h1>
</div>

<div  class="container padded" style="margin-top: 2em;">
    @if(count($portfolios) > 0)
    <div class="row">
        @each('includes.portfolio-with-user', $portfolios, 'portfolio')
    </div>
    @else
    <div class="">
        <h4 class="text-warning">We couldn't find any portfolio item matching your search</h4>
    </div>
    @endif
</div>

@if($skills->count())
<div id="categories">
    <div class="container padded">
        <h4 class="bold">Browse Portfolio by Category</h4>
        <hr>
        @foreach($skills as $skill)
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
            <a href="/work/search/?term={{ urlencode($skill->skill) }}"> {{ $skill->skill }} </a>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
