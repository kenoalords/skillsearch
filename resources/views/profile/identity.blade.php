@extends('layouts.dashboard')
@section('title', 'Verify identity')
@section('content')
<h1 class="title is-2">
    Verify Your Identity
    
</h1>
<p class="sub header"> We are building a safe community for people to interact and meet new clients and verifing your identity is just one of those steps we are taking to ensure safety</p>
<!-- <div class="ui divider"></div> -->
@if(!$user)
    <h3 class="title is-5">How it works!</h3>
    <p>Simply upload a scanned copy of a government issued identity card like;</p>
    <ul>
        <li>Drivers Licence</li>
        <li>International Passport</li>
        <li>Voters Registration Card</li>
        <li>National Identity Card</li>
    </ul>

    <form action="/dashboard/profile/identity-verify" method="post" enctype="multipart/form-data" class="ui form">
        {{ csrf_field() }}
        <div class="field">
            <label for="upload">
                <input type="file" name="identity-card" id="upload" class="">
            </label>
        </div>
        <button class="ui primary button" type="submit">Upload File</button>
    </form>
@else
    <div>
        <figure class="image" style="max-width: 320px">
            <div class="hero">
                <div class="hero-body card is-raised">
                    <div class="">
                        <img src="{{ asset($user->scan_link) }}" class="img-responsive" alt="">
                    </div>
                </div>
            </div>
            
        </figure>
        <div class="hero">
            <div style="padding: 10px 0">
                @if(!$user->status)
                    <div class="tag is-danger">
                        <span class="icon"><i class="fa fa-info-circle"></i></span> <span>Pending Approval</span>
                    </div>
                @else
                    <div class="tag is-success">
                        <span class="icon"><i class="fa fa-check-circle"></i></span> <span>Approved</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="clearfix">

        @if(!$user->status)
            <p>We have received your identity verification request, please allow 48hours for processing and approval, we will contact you if need be</p>
        @else
            <p>Congratulations!!! Your identity has been verified. Continue browsing and meeting new clients</p>
        @endif
    </div>

    <p><a href="/dashboard" class="button is-primary"><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Go back to your profile</span></a></p>
@endif


<div class="container">
    <div class="row padded">
        
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                
                <div class="panel-body">
                    
                </div>
            </div>
                
        </div>
    </div>
</div>
@endsection