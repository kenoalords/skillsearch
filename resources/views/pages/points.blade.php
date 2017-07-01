@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Earn points on ' . config('app.name') . ' while performing various actions and earn great rewards and reputation')
@section('title', 'Points')

@section('content')
	
	<div id="points-header" class="page padded text-center">
		<h1 class="bold"><i class="fa fa-trophy"></i> Points</h1>
		<h4><i class="fa fa-star"></i><i class="fa fa-star"></i> Earn points and get rewarded <i class="fa fa-star"></i><i class="fa fa-star"></i></h4>
	</div>
    <div id="page" class="container padded">
    	<div class="col-sm-8 col-sm-offset-2 padded">
    		<h3 class="bold">What are points?</h3>
    		<p>
    			Points are rewards given for performing various interactions on {{config('app.name')}}. These actions covers the main activites on the website and a few others. 
    		</p>	

    		<h3 class="bold">Why do I need points?</h3>
    		<h4 class="bold text-warning">
    			<i class="fa fa-star"></i> Rank higher than everyone else <i class="fa fa-star"></i>
    		</h4>
    		<p>
    			Earning points can greatly increase your profile and portfolio ranking on {{config('app.name')}} thereby connecting you with more clients and increasing your earnings.
    		</p>

    		<h3 class="bold">How do I earn points?</h3>
    		<p>You earn points when you perform any of these action.</p>
    		<table class="table table-bordered points-table">
    			<thead><tr>
    				<td><h4 class="bold"><i class="fa fa-line-chart"></i> Activity</h4></td>
    				<td><h4 class="bold"><i class="fa fa-trophy"></i> Points</h4></td></tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td>
    						<h4>Invite Friends</h4>
    						<p>Earned when you invite your contacts from Gmail</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.invite') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
    						<h4>Invite Signup</h4>
    						<p>Earned when someone you invited registers on {{ config('app.name') }}</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.invite_signup') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
    						<h4>Follow</h4>
    						<p>Earned when you follow other members</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.follow') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
    						<h4>Comment</h4>
    						<p>Earned when you post a comment on other members portfolio</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.comment') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
    						<h4>Like Portfolio</h4>
    						<p>Earned when you like a portfolio posted by others</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.like') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
    						<h4>Like Comment</h4>
    						<p>Earned when you like a comment posted by others</p>
    					</td>
    					<td><h4 class="bold text-gold">{{ config('services.points.comment_like') }} <small>Points</small></h4></td>
    				</tr>
    			</tbody>
    		</table>

    		<p class="text-warning bold">
    			** Please note that undoing any of these actions will automatically subtract the earned points.
    		</p>
	    </div>
	</div>

@endsection