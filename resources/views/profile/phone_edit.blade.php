@extends('layouts.admin')
@section('title', 'Edit Phone Number')
@section('content')
<h2 class="ui dividing header">
    Edit Phone Number
</h2>
<form class="inline-form" role="form" method="POST" action="{{ route('edit_phone', ['phone' => $phone->id ]) }}" class="ui form">
    {{ csrf_field() }}

    <div class="field" style="margin-bottom: 1em;">
        <div class="field {{ $errors->has('name') ? ' error' : '' }}">
            <div class="ui left icon input">
                <i class="icon phone"></i>
                <input type="text" class="form-control" aria-label="..." name="phone" placeholder="e.g 08012345678" value="{{ (old('phone')) ? old('phone') : $phone->number }}">
            </div>                          
        </div><!-- /input-group -->
    </div>   

    <div class="field" style="margin-bottom: 1em;">
        <button class="ui button primary" type="submit">Save Changes</button>
    </div>           

</form>
@endsection