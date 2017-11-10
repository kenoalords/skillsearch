@extends('layouts.app')

@section('title', 'Oops!' )

@section('content')

<div class="ui one column grid">
    <div class="ui center aligned column" style="margin-top: 4em; margin-bottom: 4em">
        <h1 class="ui grey huge header" style="font-size: 4em;">Not Found!</h1>
        <p>Did you get lost? <a href="{{ url()->previous() }}">Click here to go back.</a></p>
    </div>
</div>


@endsection
