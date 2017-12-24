@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')
    <div>
        <gig-form skills="{{ json_encode($skills) }}"></gig-form>
    </div>
@endsection
