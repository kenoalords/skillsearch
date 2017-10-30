@extends('layouts.admin')
@section('title', 'Referral')
@section('content')

<h1 class="ui header">
	Referral Code
	<div class="sub header">Generate &amp; Share your referral code</div>
</h1>
<div class="ui divider"></div>

<referral-code code="{{$code}}"></referral-code>

@endsection
