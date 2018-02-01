@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
<div class="hero is-primary is-medium is-bold">
    <div class="hero-body">
    		<div class="columns is-centered">
    			<div class="column is-8 has-text-centered">
    				<h1 class="title is-2">Invite your friends from Gmail!</h1>
    				<h4 class="title is-5">It's Fast, Easy and <span class="icon"><i class="fa fa-lock"></i></span> <span>Safe to use</span></h4>
				<p>
					<a href="/invite/gmail" class="button is-success is-raised" id="google-invite">
						<span class="icon"><i class="fa fa-google-plus"></i></span> 
						<span>Invite Friends From Gmail</span>
					</a>
				</p>
    			</div>
    		</div>
    </div>
</div>

<div class="hero is-white">
	<div class="hero-body">
		<div class="columns is-centered">
			<div class="column is-8">
				<div class="">
					@include('includes.top-users', ['title'=>'Join the team'])
				</div>
			</div>
		</div>
	</div>
</div>
@endsection