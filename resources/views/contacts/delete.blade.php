@extends('layouts.dashboard')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Manage Invites')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
    
<h1 class="title is-3">You have <span class="bold">{{ $invites }} Invites</span></h1>
<!-- <h3 class="title is-6"><span class="bold">Delete</span> Invites</h3> -->
<form action="{{ route('delete_invites') }}" method="post">
    {{ csrf_field() }}
    <div class="field">
        <label for="emails" class="label">Enter each email addresses on a new line to be deleted</label>
        <textarea name="emails" id="emails" rows="10" class="textarea"></textarea>
    </div>
    <button type="submit" class="button is-primary">Delete Invites</button>
</form>

@endsection