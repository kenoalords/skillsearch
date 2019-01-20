@extends('layouts.app')

@section('title', $blog['title'])
@section('metadescription', $blog['excerpt'])
@section('thumbnail', $blog['image'])

@section('content')
<div class="single-blog">
	<article>
		<section class="section is-dark is-">
			<header class="container">
				<h1 class="title is-1 is-size-3-mobile">{{ $blog['title'] }}</h1>
				<div class="level is-mobile meta">
					<div class="level-left">
						<div class="level-item">
							<div class="author small">
								<img src="{{$blog['profile']['avatar']}}" alt="{{$blog['profile']['fullname']}}" class="media-object img-circle" width="48" height="48"> 
								<a href="/{{$blog['profile']['username']}}">{{$blog['profile']['fullname']}} <span itemprop="author" class="{{ ($blog['profile']['verified']) ? 'verified' : '' }} author" ></span></a>
							</div>
						</div>
						<div class="level-item">
							in <a href="#" class="tag is-info">{{ $blog['category'] }}</a>
						</div>
						<div class="level-item">
							Posted {{ $blog['date']['created_human'] }}
						</div>
					</div>
				</div>
				@if($blog['excerpt'])
					<p class="text-muted"><em>{{ $blog['excerpt'] }}</em></p>
				@endif
			</header>
		</section>
		<section class="section is-white">
			<div class="container body">
				@if($blog['image'])
				<figure class="image featured">
					<img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}">
				</figure>
				@endif
				<div class="content">
					{!! $blog['body'] !!}
				</div>
				<div class="level is-mobile user-actions">
					<div class="level-left">
						<div class="level-item">
							<blog-like count="{{$blog['likes']['count']}}" uid="{{$blog['id']}}"></blog-like> 
						</div>
						<div class="level-item">
							<blog-subscribe name="{{$blog['profile']['fullname']}}" :uid="{{$blog['id']}}" :subscriber-count="{{$blog['subscriber']['count']}}" :user-id="{{$blog['user_id']}}" blog-title="{{ $blog['title'] }}"></blog-subscribe>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="section is-light">
			<div class="container">
				<div class="media profile">
					<div class="media-left">
						<p class="image is-64x64">
							<img src="{{$blog['profile']['avatar']}}" alt="{{$blog['profile']['fullname']}}">
						</p>
					</div>
					<div class="media-content">
						<strong><a href="/{{$blog['profile']['username']}}">{{$blog['profile']['fullname']}}<span itemprop="author" class="{{ ($blog['profile']['verified']) ? 'verified' : '' }} author" ></span></a></strong>
						<div class="level is-mobile">
							<div class="level-left">
								<div class="level-item">
									<span class="has-text-weight-bold is-size-7">{{$blog['profile']['followers']}} Followers</span>
								</div>
								<div class="level-item">
									<span class="has-text-weight-bold is-size-7">{{$blog['profile']['following']}} Following</span>
								</div>
							</div>
						</div>
						<p class="text-muted">{{$blog['profile']['bio']}}</p>	
						<follow username="{{$blog['profile']['username']}}"></follow>
					</div>
				</div>
			</div>
		</section>
		<section class="section">
			<div class="container">
				@if ( $blog['allow_comments'] === 1 )
					<blog-comment v-bind:blogid="{{ $blog['id'] }}"></blog-comment>
				@else
					<div class="notification is-danger">Comments have been disabled.</div>
				@endif
			</div>
		</section>
	</article>
    	
    	<div id="social-share">
	    	<div class="share modal">
	    		<div class="modal-background"></div>
	    		<div class="modal-content">
	    			<div class="card">
	    				<div class="card-content has-text-centered">
	    					<h3 class="title is-2 bold">Hello!</h3>
	    					<p>Please help us share this post with your friends, it only takes a minute.</p>
	    					<ul class="share-links">
	    						<li><a href="https://www.facebook.com/sharer/sharer.php?u={{ $blog['url'] }}" class="facebook" target="_blank">
	    							<span class="icon"><i class="fa fa-facebook"></i></span>
	    							<span>Share on Facebook</span>
	    						</a></li>
	    						<li><a href="https://twitter.com/intent/tweet?url={{$blog['url']}}&via=ubanjicreatives&text={{$blog['excerpt']}}&hashtags=ubanjicreatives" class="twitter" target="_blank">
	    							<span class="icon"><i class="fa fa-twitter"></i></span>
	    							<span>Share on Twitter</span>
	    						</a></li>
	    						<li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{$blog['url']}}&title={{$blog['title']}}&summary={{$blog['excerpt']}}&source=ubanji.com" class="linkedin" target="_blank">
	    							<span class="icon"><i class="fa fa-linkedin"></i></span>
	    							<span>Share on LinkedIn</span>
	    						</a></li>
							<li><a href="https://plus.google.com/share?url={{$blog['url']}}" class="google" target="_blank">
	    							<span class="icon"><i class="fa fa-google-plus"></i></span>
	    							<span>Share on Google+</span>
	    						</a></li>
	    					</ul>
	    					<a href="#" class="close-share-modal">Sorry, I don't have any friends</a>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
    	</div>

</div>
@endsection