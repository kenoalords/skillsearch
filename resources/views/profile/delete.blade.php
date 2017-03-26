@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        
        <div class="col-md-10 col-md-offset-1 text-center">
            <h3>Delete Your Account</h3>
            <hr>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <p>All your data will be lost if you proceed</p>
            <p>
                <a href="/profile/delete/proceed" class="btn btn-danger">Delete my account</a>
                <a href="/home" class="btn btn-basic">Cancel</a>
            </p>
        </div>

    </div>
</div>
@endsection