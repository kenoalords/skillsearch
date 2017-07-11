@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Linkedin Contacts')
@section('metadescription', '')

@section('content')
    <div class="container padded">
        <div class="col-md-10 col-md-offset-1">
            <h1><span class="bold">Linkedin </span><span class="thin">Contacts</span></h1>
            <hr>
            <form action="{{ route('submit_linkedin_contacts') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="upload">
                        <input type="file" name="upload"> Upload Linkedin Export File CSV.
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload Contacts</button>
                </div>
            </form>

            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($contacts->count())
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $contact->first_name }}</td>
                                <td>{{ $contact->last_name }}</td>
                                <td>{{ $contact->email }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection