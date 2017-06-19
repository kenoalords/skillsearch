@extends('layouts.app')

@section('title', 'Cant Apply')
@section('type', 'article')

@section('content')
<div class="container">

    <div class="row padded" id="jobs">
        <div class="col-md-10 col-md-offset-1 text-center">
            <h1 class="text-danger"><i class="fa fa-lock"></i> Locked!</h1>
            <p>Please complete your profile to submit a job</p>
            <p><a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Back!</a></p>
        </div>
    </div>
</div>
@endsection
