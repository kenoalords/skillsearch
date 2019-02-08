@extends('layouts.app')

@section('title', 'Send message')
@section('metadescription', $profile->bio)
@section('thumbnail', $profile->getAvatar())
@section('type', 'enquiry')

@section('content')

<div class="section">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-6">
				<div class="card">
					<div class="card-content">
						<div class="media">
							<div class="media-left">
								<p class="image is-48x48 is-rounded">
				                        <img src="{{ $profile->getAvatar() }}">
				                    </p>
							</div>
							<div class="media-content">
								<h1 class="title is-5 bold is-size-6-mobile">Send {{ $profile->fullname }} a message</h1>
								<p class="subtitle is-size-6">Use the form below to compose your enquiry.</p>
							</div>
						</div>
						<!-- <hr> -->
						<enquiry user="{{ $profile->user->name }}"></enquiry>
					</div>
				</div>
				<div class="has-text-centered">
					<a href="#">Go back</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection