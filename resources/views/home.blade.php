@extends('layouts.app')

@section('content')
<div class="row">

    @include('includes.profile-head')

    <div class="container padded">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            @if(!$profile->identity)
                    <p class="text-info"><i class="glyphicon glyphicon-info-sign"></i> Verify your identity and increase your ranking instantly and improve your credibility score <strong><a href="{{ route('verify_identity') }}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-info-sign"></i> Verify my identity</a></strong></p>

            @endif
            <h3><i class="glyphicon glyphicon-graph"></i> Activity Feed</h3>
            <hr>
            @if($activities)
        	<div id="activities">
        		@each('includes.activity', $activities, 'activity')
        	</div>
            @endif

            @if(!$activities)
            <div id="activities" class="padded text-center">
                <p style="font-size: 3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                <p>Your activity log in empty</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
