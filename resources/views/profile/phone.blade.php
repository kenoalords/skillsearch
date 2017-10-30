@extends('layouts.admin')
@section('title', 'Phone')
@section('content')
<h2 class="ui header">
    Phone Number
    <div class="sub header">Manage your contact number</div>
</h2>
<div class="ui divider"></div>
@if ( !$phones->count() )
    <div class="panel panel-default">
       <div class="panel-body">
           <a href="{{ route('add_phone') }}" class="ui icon green button"><i class="icon plus"></i>Add phone number</a>
        </div>
    </div>
@else

@endif

<div class="ui divided relaxed list">
@foreach ( $phones as $phone )
    <div class="item">
        <div class="right floated">
            <a href="{{ route('edit_phone', ['phone'=>$phone->id]) }}" class="ui mini icon button"><i class="icon edit"></i></a>
            <a href="{{ route('delete_phone', ['phone'=>$phone->id]) }}" class="ui mini icon button"><i class="icon delete"></i></a>
        </div>
        <div class="content">
            <div class="ui medium header"><i class="icon mobile"></i>{{ $phone->number }}</div>
        </div>
        
    </div>
@endforeach
</div>
@endsection