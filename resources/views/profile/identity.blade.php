@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-ok-sign text-primary"></i> Verify Your Identity</div>
                <div class="panel-body">
                    @if(!$user)
                        <p>We are bulding a safe community for people to interact and meet new clients and verifing your identity is just one of those steps we are taking to ensure safety</p>
                        <hr>
                        <h4>How it works!</h4>
                        <p>Simply upload a scanned copy of a government issued identity card like;</p>
                        <ul>
                            <li>Drivers Licence</li>
                            <li>International Passport</li>
                            <li>Voters Registration Card</li>
                            <li>National Identity Card</li>
                        </ul>
                        
                        <form action="/profile/identity-verify" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label class="card-frame" for="upload">
                                <i class="glyphicon glyphicon-credit-card"></i>
                                <input type="file" name="identity-card" id="upload" class="">
                            </label>
                            <button class="btn btn-primary btn-block" type="submit">Upload File</button>
                        </form>
                    @else
                        
                        <div class="card-frame text-center">
                            <img src="{{ asset($user->scan_link) }}" class="img-responsive" alt="">
                        </div>
                        <hr>
                        <div class="clearfix">
                            @if(!$user->status)
                                <p>
                                    Status: <strong class="text-warning"><i class="glyphicon glyphicon-time"></i> Pending</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp; Submitted: <strong>{{ $user->created_at->diffForHumans() }}</strong>
                                </p>
                                <hr>
                                <p>We have received your identity verification request, please allow 48hours for processing and approval, we will contact you if need be</p>
                                <p><strong>Thank you</strong></p>
                            @else
                                <p>Status: <strong class="text-success"><i class="glyphicon glyphicon-ok-sign"></i> Approved</strong></p>
                                <hr>
                                <p>Congratulations!!! Your identity has been verified. Continue browsing and meeting new clients</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
                
        </div>
    </div>
</div>
@endsection