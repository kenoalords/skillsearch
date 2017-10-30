@extends('layouts.app')
@section('title', 'Select your skills')
@section('content')

<div class="ui container" style="padding-top: 4em">
    <div class="ui centered six computer column grid">
        <div class="white-boxed">

            <skills></skills>

            <div class="ui divider"></div>

            <div class="clearfix">
                <a href="/home" class="ui fluid primary button">Continue <i class="icon arrow right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
