@extends('layouts.dashboard')
@section('title', 'Add Phone')
@section('content')
<h2 class="title is-4">
    Add Phone Number
</h2>
<h4 class="subtitle is-6">Only approved contact request will have access to your phone number</h4>

<form class="inline-form" role="form" method="POST" action="{{ route('add_phone') }}" class="ui form">
    {{ csrf_field() }}

    <div class="field is-grouped">
        <div class="control">
            <input type="text" class="input {{ $errors->has('phone') ? ' error' : '' }}" aria-label="phone" name="phone" placeholder="e.g 08012345678">
        </div><!-- /input-group -->
        <div class="control">
            <button class="button is-primary" type="submit">Add Number</button>
        </div>  
    </div>   

             

</form>
@endsection