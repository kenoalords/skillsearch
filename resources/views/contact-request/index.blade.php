@extends('layouts.account')

@section('title', 'Contact Request')

@section('content')

@if($profile['phone'])
<div class="hero">
    <div class="hero-body">
        <form action="{{ route('contact_request_post', ['user'=>$profile['username']]) }}" method="post">
            {{ csrf_field() }}
            <div class="field has-text-centered">
                <span>
                    <a href="/{{ $profile['username'] }}">
                        <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="image is-rounded is-centered">
                    </a>
                </span>
                <h1 class="title is-6">Request {{ $profile['first_name'] }}'s Contact</h1>
            </div>
            
            <div class="field">
                <input type="text" name="fullname" placeholder="Your fullname" value="{{ Request::old('fullname') }}" class="input  {{ $errors->has('fullname') ? ' is-danger' : '' }}">
                @if ($errors->has('fullname'))
                    <span class="help is-danger">
                        <strong>{{ $errors->first('fullname') }}</strong>
                    </span>
                @endif
            </div>
            <div class="field">
                <input type="email" name="email" placeholder="Your email address" value="{{ Request::old('email') }}" class="input {{ $errors->has('email') ? ' is-danger' : '' }}">
                @if ($errors->has('email'))
                    <span class="help is-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="field">
                <input type="text" name="location" placeholder="Your location (City, State)" value="{{ Request::old('location') }}" class="{{ $errors->has('location') ? ' is-danger' : '' }} input">
                @if ($errors->has('location'))
                    <span class="help is-danger">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @endif
            </div>
            <div class="field">
                <input type="text" name="phone" placeholder="Your phone number (Optional)" value="{{ Request::old('phone') }}" class="{{ $errors->has('phone') ? ' is-danger' : '' }} input">
                <input type="hidden" name="fig1" value="{{ $fig1 }}">
                <input type="hidden" name="fig2" value="{{ $fig2 }}">
            </div>
            <h3 class="title is-6">Are you human?</h3>
            <div class="field has-addons">
                <p class="control">
                    <span class="button is-static">{{$fig1}} + {{$fig2}} = </span>
                </p>
                <div class="control is-expanded">
                    <input type="text" name="result" id="" class="input {{ $errors->has('result') ? ' is-danger' : '' }}">
                    @if ($errors->has('result'))
                        <span class="help is-danger">
                            <strong>{{ $errors->first('result') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="field">
                <button type="submit" class="button is-block is-primary">Request Contact</button>
            </div>
        </form>
    </div>
</div>


@else 
<div class="hero">
    <div class="hero-body">
        <div class="field has-text-centered">
            <span>
                <a href="/{{ $profile['username'] }}">
                    <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="image is-rounded is-centered is-128x128">
                </a>
            </span>
        </div>

        <h3 class="title is-5 has-text-danger">{{ $profile['fullname'] }} is yet to setup their contact details. Please check back later</h3>

        <a href="{{url()->previous()}}" class="is-primary is-block button"><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Back</span></a>
    </div>
</div>

@endif

@endsection
