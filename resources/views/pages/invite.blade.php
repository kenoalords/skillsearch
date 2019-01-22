@extends('layouts.landing')

@section('thumbnail', asset('images/community.jpg'))
@section('type', 'article')
@section('metadescription', 'We are building the biggest creative community in Nigeria to help you gain recognition for your work and earn more. Join us today')
@section('title', 'Share your work, earn more')
@section('content')

<section class="is-medium section" style="background: url({{ asset('images/banne.jpg') }}) no-repeat center left; background-size: cover">
	<div class="container has-text-centered">
		<h1 class="title bold is-2 is-size-3-mobile has-text-white">Get recognised for your creative work</h1>
		<h4 class="subtitle is-size-5-mobile has-text-white">&amp; earn more and live freely</h4>
		<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
	</div>
</section>

<section class="section is-medium">
	<div class="container">
		<div class="columns is-centered">
			<div class="column">
				<figure class="image">
					<img src="{{ asset('images/showcase-work.jpg') }}" alt="Showcase your creative work with ease">
				</figure>
			</div>
			<div class="column is-7">
				<h2 class="title is-3 is-size-4-mobile bold">Showcase your creative work with ease.</h2>
				<p>
					We have made it easier to upload your creative works with ease. Be more expressive by uploading your works in Video, Audio or Image format.
				</p>
				<p>
					You can mix it and spice it up however you want to, just be bold and expressive.
				</p>
				<p><strong><a href="/" target="_blank">See what others have shared</a></strong></p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>
		</div>
	</div>
</section>
<section class="section is-medium is-light">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-7">
				<h2 class="title is-3 is-size-4-mobile bold">Got something to say? Try our free blog and grow your email subscription list.</h2>
				<p>Talk about your passion, interests, business or whatever you want with our free blogging tool. Be more expressive and creative with words.</p>
				<p>Our embedded email subscription form helps you grow your subscribers with ease and you can export your list whenever you feel like.</p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>
			<div class="column">
				<figure class="image">
					<img src="{{ asset('images/blog-section.jpg') }}" alt="Try our free blog and grow your subscription list">
				</figure>
			</div>
		</div>
	</div>
</section>

<section class="section is-medium is-dark	">
	<div class="container">
		<div class="columns is-centered">
			
			<div class="column is-7 has-text-centered">
				<h2 class="title is-3 is-size-4-mobile bold">Lots of skillset to choose from</h2>
				<p>From Makeup Artist to Photographer, Video Editor, Graphics Designer, Fashion Designer, Content Writers etc., You name it, we've got you covered.</p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>

		</div>
	</div>
</section>

<section class="section is-medium">
	<div class="container">
		<div class="columns is-centered">
			<div class="column">
				<figure class="image">
					<img src="{{ asset('images/be-you.jpg') }}" alt="Be creative . Be inspired . Be YOU">
				</figure>
			</div>
			<div class="column is-7">
				<h2 class="title is-3 is-size-4-mobile bold">Be creative . Be inspired . Be YOU</h2>
				<p>Be the best you can ever aspire to be. </p>
				<p>Share your work, your stories and your journey. Inspire others and be inspired, this is the value we give as a community.</p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>
		</div>
	</div>
</section>

@include('includes.signup-teaser')
@endsection