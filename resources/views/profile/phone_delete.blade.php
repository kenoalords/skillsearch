@extends('layouts.dashboard')
@section('title', 'Edit Phone Number')
@section('content')
<h2 class="title is-4 has-text-danger">
    Are you sure you want delete this number
</h2>
<h4 class="title is-5">{{$phone->number}}</h4>
<div>
    <a href="" class="button is-primary" onclick="event.preventDefault();
                                 document.getElementById('delete-phone').submit();">
        <span class="icon"><i class="fa fa-close"></i></span>
        <span>Delete</span>
    </a>
    <a href="{{ url()->previous() }}" class="button is-white">Cancel</a>
    <form action="{{route('delete_phone', ['phone'=>$phone->id])}}" method="POST" style="display: none" id="delete-phone">
        {{csrf_field()}}
    </form>
</div>
@endsection