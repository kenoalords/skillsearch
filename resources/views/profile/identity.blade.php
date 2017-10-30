@extends('layouts.admin')

@section('content')
<h1 class="ui header">
    Verify Your Identity
    <div class="sub header"> We are building a safe community for people to interact and meet new clients and verifing your identity is just one of those steps we are taking to ensure safety</div>
</h1>
<!-- <div class="ui divider"></div> -->
@if(!$user)
    <h3 class="ui grey header">How it works!</h3>
    <p>Simply upload a scanned copy of a government issued identity card like;</p>
    <ul>
        <li>Drivers Licence</li>
        <li>International Passport</li>
        <li>Voters Registration Card</li>
        <li>National Identity Card</li>
    </ul>

    <form action="/profile/identity-verify" method="post" enctype="multipart/form-data" class="ui form">
        {{ csrf_field() }}
        <div class="field">
            <label for="upload">
                <input type="file" name="identity-card" id="upload" class="">
            </label>
        </div>
        <button class="ui primary button" type="submit">Upload File</button>
    </form>
@else
    <div class="ui card">
        <div class="image">
            <img src="{{ asset($user->scan_link) }}" class="img-responsive" alt="">
        </div>
        <div class="content">
            <div class="extra content">
                @if(!$user->status)
                    <div>
                        <i class="icon wait"></i> Pending Approval
                    </div>
                @else
                    <div>
                        <i class="icon check circle"></i> Approved
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="clearfix">

        @if(!$user->status)
            <p>We have received your identity verification request, please allow 48hours for processing and approval, we will contact you if need be</p>
            <p><strong>Thank you</strong></p>
        @else
            <p>Congratulations!!! Your identity has been verified. Continue browsing and meeting new clients</p>
        @endif
    </div>

    <p><a href="/home">Go back to your profile</a></p>
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