@extends('layouts.app')

@section('content')
<div class="container">
    <!-- @include('includes.profile-head') -->
    <div class="row padded">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
        	<h3>Profile Reviews</h3>
        	<hr>
        	<div id="activities">
            	<reviews username="{{$name}}" user-id="{{ $profile->user_id }}"></reviews>
            </div>
        </div>
    </div>
</div>
@endsection