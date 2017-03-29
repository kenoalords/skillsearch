@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        @include('includes.status')
        <h2><span class="bold">Portfolio</span> <span class="thin">| Showcase your work</span></h2>
        <p>Create your portfolio and share with friends</p>
        <br>
        <div class="clearfix">
            <a href="/profile/portfolio/add" class="btn btn-primary pull-left">
                <strong><i class="glyphicon glyphicon-plus-sign"></i> Add item</strong>
            </a>
            <a href="/home" class="btn btn-basic pull-right"><i class="glyphicon glyphicon-home"></i> Back to profile</a>
        </div>
        <hr>
        
        @if ($portfolios)
            <div class="row">
                @each('includes.portfolio-owner', $portfolios, 'portfolio')
            </div>
            <!-- <p><a href="/profile/portfolio/add" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Add item</a></p> -->
        @else
            
            <div class="text-center">
                <h2>Oops!!!</h2>
                <p>You do not have any portfolio item</p>
                <p><a href="/profile/portfolio/add" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Add item</a></p>
            </div>

        @endif

    </div>
</div>
@endsection
