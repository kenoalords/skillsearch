@extends('layouts.dashboard')
@section('title', 'Phone')
@section('content')
<h2 class="title is-4">Phone Number</h2>
<div class="subtitle is-6">Manage your contact number</div>
<div class="ui divider"></div>
@if ( !$phones->count() )
    <a href="{{ route('add_phone') }}" class="button is-primary"><span class="icon"><i class="fa fa-plus"></i></span> <span>Add phone number</span></a>
@else

@endif

<div class="ui divided relaxed list">
@foreach ( $phones as $phone )
    <div class="level is-raised is-mobile" style="padding: 10px;">
        <div class="level-left">
            <div class="level-item">
                <span class="icon"><i class="fa fa-mobile"></i></span>
                <span>{{ $phone->number }}</span>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <a href="{{ route('edit_phone', ['phone'=>$phone->id]) }}" class="button is-small is-primary">
                    <span class="icon"><i class="fa fa-edit"></i></span>
                </a>
            </div>
            <div class="level-item">
                <a href="{{ route('delete_phone', ['phone'=>$phone->id]) }}" class="button is-small is-primary">
                    <span class="icon"><i class="fa fa-close"></i></span>
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection