@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Earn points on ' . config('app.name') . ' while performing various actions and earn great rewards and reputation')
@section('title', 'Points')

@section('content')
	
	<div id="points-header" class="page ui centered grid">
        <div class="center aligned fourteen wide mobile eight wide tablet eight wide computer column">
    		<h1 class="ui header">
                Ubanji Points
                <div class="sub header">Earn points and do more on {{config('app.name')}}</div>
            </h1>
        </div>
	</div>
    <div id="page" class="ui centered grid container" style="padding: 4em 1em">
    	<div class="fourteen wide mobile twelve wide tablet twelve wide computer column">
    		<h3 class="ui header">What are points?</h3>
            <p>Points are rewards given for performing various interactions on {{config('app.name')}}. These actions covers the main activites on the website and a few others.</p>
    			
    		<h3 class="ui header">
                Why do I need points?
    		</h3>

            <p>
                Earning points can greatly increase your profile and portfolio ranking on {{config('app.name')}} thereby connecting you with more clients and increasing your earnings.
            </p>
    		

    		<h3 class="ui header">
                How do I earn points?
            </h3>

            <p>You earn points when you perform any of these action;</p>
    		
    		<table class="ui celled table">
    			<tbody>
    				<tr>
    					<td>
    						<h4 class="ui header">
                                Invite Friends
                                <div class="sub header">Earned when you invite your contacts from Gmail</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.invite') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
                            <h4 class="ui header">
                                Invite Signup
                                <div class="sub header">Earned when your invite signs up on {{ config('app.name') }}</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.invite_signup') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
                            <h4 class="ui header">
                                Upload Work
                                <div class="sub header">Earned when you upload your works on {{ config('app.name') }}</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.upload_portfolio') }} <small>Points</small></h4></td>
    				</tr>
                    <tr>
                        <td>
                            <h4 class="ui header">
                                Follow
                                <div class="sub header">Earned when you follow people on {{ config('app.name') }}</div>
                            </h4>
                        </td>
                        <td><h4>{{ config('services.points.follow') }} <small>Points</small></h4></td>
                    </tr>
    				<tr>
    					<td>
                            <h4 class="ui header">
                                Comment
                                <div class="sub header">Earned when you post a comment on other members portfolio</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.comment') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
                            <h4 class="ui header">
                                Like Portfolio
                                <div class="sub header">Earned when you like a portfolio posted by others</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.like') }} <small>Points</small></h4></td>
    				</tr>
    				<tr>
    					<td>
                            <h4 class="ui header">
                                Like Comment
                                <div class="sub header">Earned when you like a comment posted by others</div>
                            </h4>
    					</td>
    					<td><h4>{{ config('services.points.comment_like') }} <small>Points</small></h4></td>
    				</tr>
    			</tbody>
    		</table>

    		<p class="text-warning bold">
    			** Please note that undoing any of these actions will automatically subtract the earned points.
    		</p>
	    </div>
	</div>

@endsection