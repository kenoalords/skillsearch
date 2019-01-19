@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
<div class="section is-medium " style="background: url({{ asset('images/hero-back.jpg') }}) no-repeat center; background-size: cover">
    <div class="container">
    		<div class="columns is-centered">
    			<div class="column is-8 has-text-centered">
    				<h1 class="title is-2 bold has-text-white">Invite your friends from Gmail!</h1>
    				<h4 class="title is-5 bold has-text-white">It's Fast, Easy and <span class="has-text-danger"><span class="icon"><i class="fa fa-lock"></i></span> <span>SAFE</span></span> to use</h4>
				<p>
					<a href="/invite/gmail" class="button is-google is-raised" id="google-invite">
						<span class="icon"><i class="fa fa-google"></i></span> 
						<span>Invite your friends</span>
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