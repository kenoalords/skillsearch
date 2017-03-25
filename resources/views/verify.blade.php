@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                

                <div class="panel-body text-center">
                     <h1>Hi {{$profile->first_name}},</h1>
                     <p>You are yet to verify your email.</p>
                     <p><a href="#" class="btn btn-primary">Resend verification email</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
