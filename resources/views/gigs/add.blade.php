@extends('layouts.dashboard')

@section('title', 'Sell a gig')

@section('content')
    <div>
        <gig-form skills="{{ json_encode($skills) }}"></gig-form>
    </div>
@endsection
