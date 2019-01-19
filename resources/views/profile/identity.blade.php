@extends('layouts.dashboard')
@section('title', 'Verify identity')
@section('content')

<div class="section">
    <div class="container">
        <h1 class="title is-3 bold">Verify Your Identity</h1>
        <p class="sub header"> We are building a safe community everyone, help us by verifying your identity.</p>
        <!-- <div class="ui divider"></div> -->
        @if(!$user)
            <h3 class="title is-5 bold">How it works!</h3>
            <p>Simply upload a scanned copy of a government issued identity card like;</p>
            <ol style="margin:0 0 2em 2em; font-weight: bold">
                <li>Drivers Licence</li>
                <li>International Passport</li>
                <li>Voters Registration Card</li>
                <li>National Identity Card</li>
            </ol>

            <form action="{{ route('verify_identity') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="field">
                    <label for="upload">
                        <input type="file" name="identity-card" id="upload" class="">
                    </label>
                </div>
                <button class="is-info button" type="submit">Upload File</button>
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

            <p><a href="/dashboard" class="button is-info is-small"><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Go back to your profile</span></a></p>
        @endif
    </div>
</div>


@endsection