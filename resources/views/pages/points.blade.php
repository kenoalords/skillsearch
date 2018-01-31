@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Earn points on ' . config('app.name') . ' while performing various actions and earn great rewards and reputation')
@section('title', 'Points')

@section('content')
	
<h1 class="title">
    Ubanji Points
</h1>
<p>Earn points and do more on {{config('app.name')}}</p>

<h3 class="title is-4">What are points?</h3>
<p>Points are rewards given for performing various interactions on {{config('app.name')}}. These actions covers the main activites on the website and a few others.</p>
    
<h3 class="title is-5">
    Why do I need points?
</h3>

<p>
    Earning points can greatly increase your profile and portfolio ranking on {{config('app.name')}} thereby connecting you with more clients and increasing your earnings.
</p>


<h3 class="title is-5">
    How do I earn points?
</h3>

<p>You earn points when you perform any of these action;</p>

<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth" id="points-header">
    <tbody>
        <tr>
            <td>
                <h4 class="title is-6">
                    Invite Friends
                </h4>
                <p>Earned when you invite your contacts from Gmail</p>
            </td>
            <td><h4>{{ config('services.points.invite') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Invite Signup
                </h4>
                <p>Earned when your invite signs up on {{ config('app.name') }}</p>
            </td>
            <td><h4>{{ config('services.points.invite_signup') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Upload Work
                </h4>
                <p>Earned when you upload your works on {{ config('app.name') }}</p>
            </td>
            <td><h4>{{ config('services.points.upload_portfolio') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Follow
                </h4>
                <p>Earned when you follow people on {{ config('app.name') }}</p>
            </td>
            <td><h4>{{ config('services.points.follow') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Comment
                </h4>
                <p>Earned when you post a comment on other members portfolio</p>
            </td>
            <td><h4>{{ config('services.points.comment') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Like Portfolio
                </h4>
                <p>Earned when you like a portfolio posted by others</p>
            </td>
            <td><h4>{{ config('services.points.like') }} <small>Points</small></h4></td>
        </tr>
        <tr>
            <td>
                <h4 class="title is-6">
                    Like Comment
                </h4>
                <p>Earned when you like a comment posted by others</p>
            </td>
            <td><h4>{{ config('services.points.comment_like') }} <small>Points</small></h4></td>
        </tr>
    </tbody>
</table>

<p class="text-warning bold">
    ** Please note that undoing any of these actions will automatically subtract the earned points.
</p>

@endsection