@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
	
	<div class="ui grid">
		<h1 class="ui medium header">Review your order</h1>
		<table class="ui table">
			<tr>
				<td>Order ID</td>
				<td>{{ $order_id }}</td>
			</tr>
			<tr>
				<td>Total</td>
				<td><span class="naira">{{ number_format($amount) }}</span></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
		<form class="ui form row" method="POST" action="{{ route('pay') }}" accept-charset="UTF-8">
			<input type="hidden" name="amount" value="{{ $amount_kobo }}">
			<input type="hidden" name="email" value="{{ Request::user()->email }}">
			<input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
			<input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">
			{{ csrf_field() }}
			<button type="submit" class="ui large fluid green button">Pay Now!<i class="icon arrow right"></i></button>
		</form>
	</div>
	

@endsection