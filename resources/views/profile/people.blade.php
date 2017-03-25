@extends('layouts.app')

@section('content')
<div class="container padded">
        
        @include('search-form')        

        @if ( count($profiles) )
            <div class="row">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
        @endif
        
                
            
</div>
@endsection
