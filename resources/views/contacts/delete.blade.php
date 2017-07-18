@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Manage Invites')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    
    <div class="container padded">
        <div class="col-md-8 col-md-offset-2">
            <h1>You have <span class="bold">{{ $invites }} Invites</span></h1>
            <hr>
            <h3><span class="bold">Delete</span> Invites</h3>
            <form action="{{ route('delete_invites') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="emails">Enter each email addresses on a new line</label>
                    <textarea name="emails" id="emails" rows="10" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Delete Invites</button>
            </form>
        </div>
    </div>

@endsection