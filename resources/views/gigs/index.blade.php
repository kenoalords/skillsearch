@extends('layouts.dashboard')

@section('title', 'My Gigs')

@section('content')

<h1 class="title is-3">My Gigs</h1>
<p class="subtitle is-6">Sell your services online</p>

@include('gigs.menu')

@if($gigs)
   <div class="columns is-multiline">
       @each('gigs.includes.gig', $gigs, 'gig')
   </div>
@endif

<a href="{{ route('add_gig') }}" class="button is-primary">
	<span class="icon"><i class="fa fa-plus"></i></span>
	<span>Sell a gig</span>
</a>

@endsection