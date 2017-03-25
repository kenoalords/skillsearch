@extends('layouts.app')

@section('content')


<div style="background: #fff">
<div class="container padded">


	<div class="col-md-8 col-md-offset-2">
		<div class="clearfix">
            <div class="pull-left">
                <img src="{{ $user->getAvatar() }}" alt="" class="img-circle" width="32" height="32">
                <span>{{ $user->getFullname() }}</span>
            </div>
        </div>
        <hr>
		<blog-form></blog-form>

	</div>
    
</div>
</div>
@endsection
