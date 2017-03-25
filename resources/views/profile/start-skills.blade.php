@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center">Select your skills</h2>
            <p class="text-center">
                You can select a maximum of 5 skills
            </p>
            <hr>
            <skills></skills>
            <hr>
            <div class="clearfix">
            	<a href="/home" class="btn btn-primary pull-right">Continue <i class="glyphicon glyphicon-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
