@extends('layouts.admin')

@section('title', 'My Portfolio')

@section('content')
<div class="">
    @include('includes.status')
    <h1 class="ui header">
        Portfolio
        <div class="sub header">Upload &amp; Manage your works</div>
    </h1>
    <div class="ui divider"></div>
    @if(count($portfolios) < 3)
    <div class="ui warning message">
        <i class="icon warning circle"></i> You need a minimun of 3 portfolio items to apply for jobs
    </div>
    @endif
    
    @if ($portfolios)
        <div class="ui grid">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
        <div class="divider ui" style="visibility: hidden;"></div>
        <p><a href="/profile/portfolio/add" class="ui green icon button"><i class="icon plus"></i>Upload work</a></p>
    @else
       <a href="/profile/portfolio/add" class="ui green icon button"><i class="icon plus"></i>Upload work</a>

    @endif

</div>
@endsection
