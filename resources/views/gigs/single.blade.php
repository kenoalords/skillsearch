@extends('layouts.app')

@section('title', 'I will ' . $gig['title'])

@section('content')
	

	<div class="ui container grid" style="margin-bottom: 4em">
		<div class="eleven wide computer column single-gig">
			@include('includes.status')
			<div class="ui segment">
				<h1 class="ui header">
					I will {{ ucwords( $gig['title'] ) }}
					<div class="sub header">
						{{ $gig['category'] }}
					</div>
				</h1>
				<div class="ui green huge top ribbon label">
					<span class="naira">{{ number_format( $gig['sale_price'] ) }}</span>
				</div>
				<!-- <div class="ui divider"></div> -->
				<div class="image-wrapper">
					<img src="{{ $gig['image'] }}" alt="I will {{ $gig['title'] }}" class="ui fluid image">
				</div>

				<div class="content">
					@if( $gig['description'] )
						<p>{{ nl2br( $gig['description'] ) }}</p>
					@endif
					<div class="ui small three statistics">
						<div class="green statistic">
							<div class="value"><span class="naira">{{ number_format( $gig['sale_price'] ) }}</span></div>
							<div class="label"><del class="naira">{{ number_format( $gig['regular_price'] ) }}</del></div>
						</div>
						<div class="statistic">
							<div class="value">{{ $gig['delivery_time'] }}</div>
							<div class="label">Days</div>
						</div>
						<div class="statistic">
							<div class="value">
								<a href="{{ route('add_to_cart', ['gig' => $gig['uid'] ]) }}" class="ui huge fluid green button">
									<i class="icon cart"></i> Buy now
								</a>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="five wide computer column">
			<div class="ui center aligned segment">
				<div class="">
					<img src="{{ $gig['user']['avatar'] }}" alt="{{ $gig['user']['fullname'] }}" class="ui tiny centered circular image">
					<h3 class="ui header">
						<a href="{{ $gig['user']['username'] }}">{{ $gig['user']['fullname'] }}</a>
						<div class="sub header">{{ $gig['user']['location'] }}</div>
					</h3>
				</div>

			</div>
		</div>
	</div>
	

@endsection