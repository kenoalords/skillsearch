@extends('layouts.app')

@section('title', 'Submit Job')
@section('metadescription', 'Submit your jobs and hire only the best hands on ' . config('app.name'))
@section('type', 'article')

@section('content')

<div class="container">
<img src="{{ asset('public/job-banner.jpg') }}" alt="" class="img-responsive">
</div>
<div class="container padded">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h1><span class="bold">Submit Your Job</span> <span class="thin">| Hire The Best</span></h1>
        </div>
    </div>
    <hr>
    <div class="row text-center">
        <p>Focus on what matters to you the most while we help you find the best hands to meet your Needs</p>
        <p><a href="{{ route('add_task') }}" class="btn btn-primary">Submit Your Job Today</a></p>
    </div>
</div>
@endsection
