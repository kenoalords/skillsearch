@extends('layouts.admin')

@section('content')

<h2 class="ui red header">Delete Your Account</h2>
<div class="ui divider"></div>
<p>Are you sure you want to delete your account? This action cannot be undone.</p>
<p>All your data will be lost if you proceed</p>
<p>
    <a href="/profile/delete/proceed" class="ui red icon labeled button"><i class="icon delete"></i>Delete my account</a>
    <a href="/home" class="">Cancel</a>
</p>

@endsection