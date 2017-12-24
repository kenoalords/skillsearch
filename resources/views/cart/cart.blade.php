@extends('layouts.app')

@section('title', 'Cart')

@section('content')
	
	<div class="ui centered grid" style="margin: 4em 0">
		<div class="ten wide column">
			@include('includes.status')
			@if($items)
				<h1 class="ui medium header"><i class="icon cart"></i>You have {{ count($items) }} items in your cart </h1>
				<table class="ui celled striped compact table">
					
					<tbody>
						@foreach ( $items as $gig )
						<tr>
							<td class="collapsing">
								<img src="{{ $gig['image'] }}" alt="{{$gig['title']}}" class="ui tiny image">
							</td>
							<td>
								<h4 class="ui header">I will {{$gig['title']}}</h4>
							</td>
							<td class="bold">
								<span class="naira"></span>{{ number_format($gig['sale_price'])}}
							</td>
							<td class="collapsing">
								<a href="{{ route('delete_from_cart', ['uid'=>$gig['uid']]) }}" class="circular ui tiny icon button"><i class="icon delete"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="1"></th>
							<th><h3>Total</h3></th>
							<th>
								<h3><span class="naira"></span>{{ number_format($total)}}</h3>
							</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
				<div class="ui row">
					<a href="{{ route('gigs') }}" class="ui grey text" style="margin-top: 1em; display: inline-block;"><i class="icon arrow left"></i> Continue shopping</a>
					<a href="{{ route('checkout') }}" class="ui right floated huge green button">Checkout <i class="icon arrow right"></i></a>
				</div>
			@else
			<div class="ui center aligned padded row">
				<h1 class="ui red header"><i class="icon cart"></i>Your cart is empty</h1>
				<a href="{{ route('gigs') }}" class="ui button"><i class="icon arrow left"></i>Back to shop</a>
			</div>
			@endif
		</div>
	</div>
	

@endsection