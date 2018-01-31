@extends('layouts.app')

@section('title', 'I will ' . $gig['title'])

@section('content')
	
<div>
	<div class="hero is-light is-medium">
		<div class="hero-body">
			<div class="columns is-centered">
				<div class="column is-10">
					<div class="columns">
						<div class="column is-5">
							<figure class="image has-percentage">
								<img src="{{ $gig['image'] }}" alt="I will {{ $gig['title'] }}">
								<span class="percentage">
									{{ $gig['percentage'] }}%
									<span>OFF</span>
								</span>
							</figure>
						</div> <!-- Column is-9 end -->
						<div class="column is-7">
							<div style="margin-bottom: 1em;">
								<a href="/{{ $gig['user']['username'] }}" class="has-text-weight-bold" style="margin-right: 10px;">
									<img src="{{ $gig['user']['avatar'] }}" alt="{{ $gig['user']['fullname'] }}" class="is-24x24 is-rounded is-inline is-borderless image" style="position: relative; top: 5px">
									<span>{{ $gig['user']['fullname'] }}</span>
								</a>   
								
							</div>
							<h1 class="title is-3">
								I Will {{ ucwords( $gig['title'] ) }}
							</h1>
							<span class="tag is-link">{{ $gig['category'] }}</span>
							<span class="tag has-text-weight-bold">Delivery timeframe: {{ $gig['delivery_time'] }} Days</span>
							@if( $gig['description'] )
								<p>{{ nl2br( $gig['description'] ) }}</p>
							@endif
							<h4 class="title is-3 has-text-success naira">{{ number_format( $gig['sale_price'] ) }}</h4>
							@if($gig['regular_price'])
							<h4 class="subtitle is-5"><del class="naira">{{ number_format( $gig['regular_price'] ) }}</del></h4>
							@endif
							<h4><a href="{{ route('add_to_cart', ['gig' => $gig['uid'] ]) }}" class="button is-danger has-text-weight-bold is-medium is-raised">
								 <span>Buy now @ <span class="naira">{{ number_format( $gig['sale_price'] ) }}</span></span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
							</a></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="hero is-white">
		<div class="hero-body">
			<div class="columns is-centered">
				<div class="column is-10">
					<h1 class="title is-4">Similar gigs</h1>
				</div>
			</div>
		</div>
	</div>
	
</div>

@include('includes.skills')

@endsection