@extends('layouts.admin')
@section('title', 'Add Phone')
@section('content')
<h2 class="ui dividing header">
    Add Phone Number
    <span class="sub header">Only approved contact request will have access to your phone number</span>
</h2>
<form class="inline-form" role="form" method="POST" action="{{ route('add_phone') }}" class="ui form">
    {{ csrf_field() }}

    <div class="field" style="margin-bottom: 1em;">
        <div class="field {{ $errors->has('name') ? ' error' : '' }}">
            <div class="ui left icon input">
                <i class="icon phone"></i>
                <input type="text" class="form-control" aria-label="..." name="phone" placeholder="e.g 08012345678">
            </div>                          
        </div><!-- /input-group -->
    </div>   

    <div class="field" style="margin-bottom: 1em;">
        <button class="ui button primary" type="submit">Add Number</button>
    </div>           

</form>
@endsection