@extends('layouts.user')
@section('title', 'Edit Phone Number')
@section('content')
<h2 class="ui red medium header">
    Are you sure you want delete this number
</h2>
<div class="ui huge header" style="margin-top: 0;">{{$phone->number}}</div>
<div>
    <a href="" class="ui red icon labeled button" onclick="event.preventDefault();
                                 document.getElementById('delete-phone').submit();">
        <i class="icon delete"></i>Delete                                 
    </a>
    <a href="{{ url()->previous() }}" class="ui grey text">Cancel</a>
    <form action="{{route('delete_phone', ['phone'=>$phone->id])}}" method="POST" style="display: none" id="delete-phone">
        {{csrf_field()}}
    </form>
</div>
@endsection