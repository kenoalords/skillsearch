@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Linkedin Contacts')
@section('metadescription', '')

@section('content')
    <div class="container padded">
        <div class="col-md-10 col-md-offset-1">
            <h1><span class="bold">{{$contacts}} Linkedin </span><span class="thin">Contacts</span></h1>
            <hr>
            <h3>Upload Linkedin Contacts</h3>
            <form action="{{ route('submit_linkedin_contacts') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="upload">
                        <input type="file" name="upload">
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload Contacts</button>
                </div>
            </form>

            <hr>
            
            <h3>Delete Contacts</h3>
            <form action="{{ route('delete_linkedin_contacts') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="emails">Enter each email addresses on a new line</label>
                    <textarea name="emails" id="emails" rows="10" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Delete Contacts</button>
            </form>
        </div>
    </div>
@endsection