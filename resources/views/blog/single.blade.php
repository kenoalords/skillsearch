@extends('layouts.app')

@section('title', $blog['title'])

@section('content')

<div style="background: #fff; margin-top: 3em">
<div class="container padded" id="single-blog">
	<div class="col-md-8 col-md-offset-2">
		<div class="media profile">
			<div class="media-left">
				<img src="{{$blog['profile']['avatar']}}" alt="{{$blog['profile']['fullname']}}" class="media-object img-circle" width="48" height="48">
			</div>
			<div class="media-body">
				<h5 class="media-heading bold">
					<a href="/{{$blog['profile']['username']}}">{{$blog['profile']['fullname']}}</a>
				</h5>
				<p class="text-muted">{{str_limit($blog['profile']['bio'], 64)}}</p>
				<small>
					{{ $blog['date']['created_human'] }}
				</small>
			</div>
		</div>
		<h1 class="bold big">{{ $blog['title'] }}</h1>
		<ul class="list-inline bold text-muted">
			<li>
				<i class="fa fa-tags"></i> <a href="#">{{ $blog['category'] }}</a>
			</li>
		</ul>
		@if($blog['excerpt'])
		<p class="text-muted"><em>{{ $blog['excerpt'] }}</em></p>
		@endif
		<div class="text-muted text-center" style="font-size: 8px">
			<small class="fa fa-circle"></small>
			<small class="fa fa-circle"></small>
			<small class="fa fa-circle"></small>
		</div>
		<div class="blog-content padded">
			{!! $blog['body'] !!}
		</div>
		<div class="padded">
			<blog-like count="{{$blog['likes']['count']}}" uid="{{$blog['uid']}}"></blog-like> 
			<blog-subscribe name="{{$blog['profile']['fullname']}}" uid="{{$blog['uid']}}" subscriber-count="{{$blog['subscriber']['count']}}" user-id="{{$blog['user_id']}}"></blog-subscribe> 
		</div>
	</div>
    <div class="col-md-8 col-md-offset-2">
    	<div class="media profile">
			<div class="media-left">
				<img src="{{$blog['profile']['avatar']}}" alt="{{$blog['profile']['fullname']}}" class="media-object img-circle" width="48" height="48">
			</div>
			<div class="media-body">
				<h5 class="media-heading bold">
					<a href="/{{$blog['profile']['username']}}">{{$blog['profile']['fullname']}}</a>
				</h5>
				<ul class="list-inline bold text-muted" style="font-size: 12px; margin:5px 0">
					<li>{{$blog['profile']['followers']}} Followers</li>
					<li>{{$blog['profile']['following']}} Following</li>
				</ul>
				<p class="text-muted">{{$blog['profile']['bio']}}</p>
				
			</div>
		</div>
    </div>
</div>
</div>
@endsection