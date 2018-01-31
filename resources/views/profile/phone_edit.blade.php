@extends('layouts.dashboard')
@section('title', 'Edit Phone Number')
@section('content')
<h2 class="title is-4">
    Edit Phone Number
</h2>
<form class="inline-form" role="form" method="POST" action="{{ route('edit_phone', ['phone' => $phone->id ]) }}" class="ui form">
    {{ csrf_field() }}

    <div class="field is-grouped" style="margin-bottom: 1em;">
        <div class="control">
            <div class="field">
                <input type="text" class="input {{ $errors->has('phone') ? ' is-danger' : '' }}" aria-label="..." name="phone" placeholder="e.g 08012345678" value="{{ (old('phone')) ? old('phone') : $phone->number }}">
            </div>                          
        </div><!-- /input-group -->
        <div class="control">
            <button class="button is-primary" type="submit">Save Changes</button>
        </div>  
    </div>   

</form>
@endsection