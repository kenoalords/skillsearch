@extends('layouts.dashboard')

@section('title', 'My Portfolio')

@section('content')
<div class="">
    @include('includes.status')
    <h1 class="title is-3">Portfolio</h1>
    <div class="subtitle is-6">Upload &amp; Manage your works</div>
    @include('portfolio.menu')
    @if(count($portfolios) < 3)
    <div class="notification is-info">
        <i class="fa fa-warning-circle"></i>&nbsp; You need a minimun of 3 portfolio items to apply for jobs
    </div>
    @endif
    
    @if ($portfolios)
        <div class="columns is-multiline">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
        
        <p><a href="/dashboard/portfolio/add" class="button is-primary"><i class="fa fa-plus"></i>&nbsp;Upload work</a></p>
    @else
       <a href="/dashboard/portfolio/add" class="button is-primary"><i class="fa fa-plus"></i>&nbsp;Upload work</a>

    @endif

</div>
@endsection
