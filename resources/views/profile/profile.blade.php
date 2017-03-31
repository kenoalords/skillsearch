@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name)
@section('metadescription', e(str_limit($profile->bio, 100)))
@section('thumbnail', $profile->getAvatar())
@section('type', 'article')

@section('content')

<div id="profile-back">
    <div class="user-background">
        <img src="{{ $profile->getUserBackground() }}" alt="{{ $profile->first_name }} {{ $profile->last_name }}">
    </div>
    <div class="container">
        <div class="col-md-6 col-md-offset-3 text-center">
            
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="clearfix row padded">
            <div class="col-md-3">
                <div class="white-boxed">
                    <div class="text-center">
                        <div style="margin-bottom: 1em">
                            <img src="{{ $profile->getAvatar() }}" width="100" height="100" class="img-circle avatar" style="margin-bottom: 0">
                        </div>
                        <div>
                            <h1 class="small-header">{{ $profile->first_name }} {{ $profile->last_name }} {!! identity_check($profile->getVerified()) !!}</h1>
                            <p><i class="glyphicon glyphicon-map-marker"></i> {{ $profile->location }}</p>
                            <p class="skills-default">
                            @foreach ($profile->skills as $skill)
                                <a href="/search?term={{ urlencode($skill->skill) }}" class="label label-xs label-default">{{ $skill->skill }}</a>
                            @endforeach
                            </p>
                        </div>
                    </div>
                    <br>
                    <div>
                        {{-- $profile->bio --}}
                        <p><follow username="{{$name}}"></follow></p>
                        
                        @if(Auth::user() && Auth::user()->id !== $profile->user_id)
                            <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-success btn-sm btn-block"><i class="fa fa-envelope"></i> Hire</a>
                        @endif

                        @if(!Auth::user())
                            <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-success btn-sm btn-block"><i class="fa fa-envelope"></i> Hire</a>
                        @endif
                     </div>

                    <!-- <p>{!! verifyStatus($profile) !!}</p> -->
                    @if($profile->phones->count() && Auth::user())
                        <hr>
                        <div class="padded">
                            <h4>Contact Number</h4>
                            @foreach($profile->phones as $phone)
                            <span><i class="glyphicon glyphicon-phone"></i> {{$phone->number}}</span>
                            @endforeach
                        </div>
                    @endif
                    
                </div>
            </div>

            <div class="col-md-9">
                <div class="">
                    @if(count($portfolios))
                        <div class="row" id="showcase" style="padding: 0">
                            @each('includes.portfolio', $portfolios, 'portfolio')
                        </div>
                    @endif
                    @if(count($portfolios) == 0)
                        <div class="text-center">
                            <h1><i class="fa fa-frown-o"></i></h1>
                            <p>{{ $profile->first_name }} has nothing to show at the moment!</p>
                        </div>
                    @endif
                </div>
            </div>
            
            
        </div>

        

        

    </div>
</div>
@endsection
