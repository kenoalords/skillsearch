@extends('layouts.app')

@section('content')
@include('search-form') 
<div class="container padded">
        
        <h1 class="text-center medium-header bold">Discover Amazing Talents in Nigeria</h1>   
		<hr>
        @if ( count($profiles) )
            <div class="row">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
        @endif
        
                
            
</div>
@endsection
