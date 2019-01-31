@extends('layouts.landing')

@section('thumbnail', asset('images/community.jpg'))
@section('type', 'article')
@section('metadescription', 'We are building the biggest creative community in Nigeria to help you gain recognition for your work and earn more. Join us today')
@section('title', 'Share your work, earn more')
@section('content')

<section class="is-medium section" style="background: url({{ asset('images/hero-back.jpg') }}) no-repeat center left; background-size: cover">
	<div class="container has-text-centered">
		<h1 class="title bold is-2 is-size-4-mobile has-text-white">Upload your creative work</h1>
		<h4 class="subtitle is-size-6-mobile has-text-white">Get recognized, earn more and live freely 🤗</h4>
		@if(Auth::user())
			<a href="{{ route('new_portfolio') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Share your work today</a>
		@else
			<a href="{{ route('register') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Sign up today</a>
		@endif
	</div>
</section>

<section class="section is-medium">
	<div class="container has-text-centered">
		<div class="columns is-centered">
			<div class="column is-8">
				<h2 class="title is-3 is-size-4-mobile bold" style="margin-bottom: 1em;">We are helping creative people like you reach a wider audience and earn more clients</h2>
				<!-- <hr> -->
				<iframe width="560" height="315" src="https://www.youtube.com/embed/y3zXpVkNKfc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<br><br>
				@if(Auth::user())
					<a href="{{ route('new_portfolio') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Share your work today</a>
				@else
					<a href="{{ route('register') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Sign up today</a>
				@endif
				<p style="margin-top: 1.5em; font-weight: bold;">
					<a href="{{ route('home') }}" style="color: #aaa">See what people are sharing</a>
				</p>
			</div>
		</div>
	</div>
</section>

<div class="section is-medium is-dark bold">
	<div class="container has-text-centered" style="max-width: 640px;">
		<h2 class="title is-2 bold is-size-4-mobile">Be expressive 😎</h2>
		<p>
			Upload your work in any format that works best for you.
		</p>
		<div class="level is-mobile" style="margin: 2em 0;">
			<div class="level-item has-text-centered">
				<div>
					<div>
						<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBoZWlnaHQ9IjY0cHgiIHZpZXdCb3g9IjAgLTM2IDUxMiA1MTEiIHdpZHRoPSI2NHB4Ij48cGF0aCBkPSJtMjMxLjg5ODQzOCAxOTguNjE3MTg4YzI4LjIwMzEyNCAwIDUxLjE1MjM0My0yMi45NDUzMTMgNTEuMTUyMzQzLTUxLjE0ODQzOCAwLTI4LjIwNzAzMS0yMi45NDkyMTktNTEuMTUyMzQ0LTUxLjE1MjM0My01MS4xNTIzNDQtMjguMjAzMTI2IDAtNTEuMTQ4NDM4IDIyLjk0NTMxMy01MS4xNDg0MzggNTEuMTUyMzQ0IDAgMjguMjAzMTI1IDIyLjk0NTMxMiA1MS4xNDg0MzggNTEuMTQ4NDM4IDUxLjE0ODQzOHptMC03Mi4zMDA3ODJjMTEuNjY0MDYyIDAgMjEuMTUyMzQzIDkuNDg4MjgyIDIxLjE1MjM0MyAyMS4xNTIzNDQgMCAxMS42NjAxNTYtOS40ODgyODEgMjEuMTQ4NDM4LTIxLjE1MjM0MyAyMS4xNDg0MzgtMTEuNjYwMTU3IDAtMjEuMTQ4NDM4LTkuNDg4MjgyLTIxLjE0ODQzOC0yMS4xNDg0MzggMC0xMS42NjQwNjIgOS40ODgyODEtMjEuMTUyMzQ0IDIxLjE0ODQzOC0yMS4xNTIzNDR6bTAgMCIgZmlsbD0iI0ZGRkZGRiIvPjxwYXRoIGQ9Im00OTMuMzA0Njg4LjVoLTQ3NC42MDkzNzZjLTEwLjMwODU5MyAwLTE4LjY5NTMxMiA4LjM4NjcxOS0xOC42OTUzMTIgMTguNjk1MzEydjQwMS43MjY1NjNjMCAxMC4zMDg1OTQgOC4zODY3MTkgMTguNjk1MzEzIDE4LjY5NTMxMiAxOC42OTUzMTNoNDc0LjYwOTM3NmMxMC4zMDg1OTMgMCAxOC42OTUzMTItOC4zODY3MTkgMTguNjk1MzEyLTE4LjY5NTMxM3YtNDAxLjcyNjU2M2MwLTEwLjMwODU5My04LjM4NjcxOS0xOC42OTUzMTItMTguNjk1MzEyLTE4LjY5NTMxMnptLTExLjMwNDY4OCAzMHYyMzcuNDA2MjVsLTk0LjM1MTU2Mi05NC4zNTU0NjljLTYuMTUyMzQ0LTYuMTQwNjI1LTE2LjE1NjI1LTYuMTM2NzE5LTIyLjMwNDY4OC4wMTE3MTlsLTEzMy40NDE0MDYgMTMzLjQ0MTQwNi04NS4yMzgyODItODUuMjM0Mzc1Yy0yLjk4MDQ2OC0yLjk4NDM3NS02Ljk0NTMxMi00LjYyODkwNi0xMS4xNjQwNjItNC42Mjg5MDYtNC4yMTQ4NDQgMC04LjE3NTc4MSAxLjY0MDYyNS0xMS4xNTYyNSA0LjYyMTA5NGwtOTQuMzQzNzUgOTQuMzQzNzV2LTI4NS42MDU0Njl6bS00NTIgMzc5LjExNzE4OHYtNTEuMDg1OTM4bDEwNS41LTEwNS41IDg1LjIzNDM3NSA4NS4yMzQzNzVjMi45ODQzNzUgMi45ODQzNzUgNi45NDkyMTkgNC42MzI4MTMgMTEuMTY3OTY5IDQuNjMyODEzIDQuMjEwOTM3IDAgOC4xNzU3ODEtMS42NDQ1MzIgMTEuMTUyMzQ0LTQuNjI1bDEzMy40NDUzMTItMTMzLjQ0NTMxMyAxMDUuNTAzOTA2IDEwNS41MDM5MDZ2OTkuMjg1MTU3em0wIDAiIGZpbGw9IiNGRkZGRkYiLz48L3N2Zz4K" />
					</div>
					<p>Image</p>
				</div>
			</div>
			<div class="level-item has-text-centered">
				<div>
					<div>
						<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU3IDU3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NyA1NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI2NHB4IiBoZWlnaHQ9IjY0cHgiPgo8Zz4KCTxwYXRoIGQ9Ik01NS4zMzIsNi42NDNjLTEuMDItMC40MzgtMi4xNTYtMC4yMzUtMi45NTIsMC41MjNMNDEsMTcuNjY5VjguOTQ0QzQxLDYuMjE4LDM4Ljc4Miw0LDM2LjA1Niw0SDQuOTQ0ICAgQzIuMjE4LDQsMCw2LjIxOCwwLDguOTQ0djIzLjI2NUMwLDM0Ljg1MSwyLjE0OSwzNyw0Ljc5MSwzN2gxNC43NzVsLTYuNzYyLDE0LjU3OWMtMC4yMzIsMC41MDEtMC4wMTUsMS4wOTYsMC40ODYsMS4zMjggICBDMTMuNDI2LDUyLjk3MSwxMy41NjksNTMsMTMuNzEsNTNjMC4zNzcsMCwwLjczOC0wLjIxNSwwLjkwOC0wLjU3OWw2LjUxNC0xNC4wNDRsNi41MTQsMTQuMDQ0QzI3LjgxNSw1Mi43ODUsMjguMTc2LDUzLDI4LjU1Myw1MyAgIGMwLjE0MSwwLDAuMjg0LTAuMDI5LDAuNDItMC4wOTNjMC41MDEtMC4yMzIsMC43MTktMC44MjcsMC40ODYtMS4zMjhMMjIuNjk4LDM3aDEzLjEyOUMzOC42NzksMzcsNDEsMzQuNjc5LDQxLDMxLjgyNnYtOC4wMDIgICBsMTEuMzIsMTAuODE5YzAuNTMxLDAuNTI5LDEuMjEzLDAuODA4LDEuOTE3LDAuODA4YzAuMzUzLDAsMC43MS0wLjA2OSwxLjA1Ny0wLjIxMkM1Ni4zMzEsMzQuODEyLDU3LDMzLjgwOSw1NywzMi42ODN2LTIzLjUgICBDNTcsOC4wNTgsNTYuMzYxLDcuMDg0LDU1LjMzMiw2LjY0M3ogTTM5LDMxLjgyNkMzOSwzMy41NzYsMzcuNTc3LDM1LDM1LjgyNywzNUgyMS4xNjljLTAuMDAyLDAtMC4wMDQsMC0wLjAwNiwwaC0wLjA2MSAgIGMtMC4wMDMsMC0wLjAwNywwLTAuMDEsMEg0Ljc5MUMzLjI1MiwzNSwyLDMzLjc0OCwyLDMyLjIwOVY4Ljk0NEMyLDcuMzIxLDMuMzIxLDYsNC45NDQsNmgzMS4xMTJDMzcuNjc5LDYsMzksNy4zMjEsMzksOC45NDQgICBWMzEuODI2eiBNNTUsMzIuNjgzYzAsMC40NzctMC4zNTcsMC42NjEtMC40NjcsMC43MDZjLTAuMTM2LDAuMDU3LTAuNDg4LDAuMTUyLTAuODAzLTAuMTY1TDQxLjIyMSwyMS4yNyAgIGMtMC4xNDYtMC4xNDctMC4yMjQtMC4zNDQtMC4yMjEtMC41NTNjMC4wMDMtMC4yMDksMC4wODctMC40MDIsMC4yMjgtMC41MzZsMTIuNTItMTEuNTU2YzAuMTY5LTAuMTYxLDAuMzQ2LTAuMjA4LDAuNDk1LTAuMjA4ICAgYzAuMTMsMCwwLjIzOSwwLjAzNywwLjMwMSwwLjA2M0M1NC42NSw4LjUyNiw1NSw4LjcxMyw1NSw5LjE4M1YzMi42ODN6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8cGF0aCBkPSJNMTguMTM3LDE5LjcyM0MxOC42ODMsMTguNzcyLDE5LDE3LjY3MywxOSwxNi41YzAtMy41ODQtMi45MTYtNi41LTYuNS02LjVTNiwxMi45MTYsNiwxNi41UzguOTE2LDIzLDEyLjUsMjMgICBjMS42ODcsMCwzLjIyMS0wLjY1MSw0LjM3Ny0xLjcwOWwxLjQxNiwxLjQxNkMxOC40ODgsMjIuOTAyLDE4Ljc0NCwyMywxOSwyM3MwLjUxMi0wLjA5OCwwLjcwNy0wLjI5MyAgIGMwLjM5MS0wLjM5MSwwLjM5MS0xLjAyMywwLTEuNDE0TDE4LjEzNywxOS43MjN6IE0xMi41LDIxQzEwLjAxOSwyMSw4LDE4Ljk4MSw4LDE2LjVzMi4wMTktNC41LDQuNS00LjVzNC41LDIuMDE5LDQuNSw0LjUgICBjMCwwLjYxNS0wLjEyNSwxLjIwMS0wLjM1LDEuNzM2bC0xLjk0My0xLjk0M2MtMC4zOTEtMC4zOTEtMS4wMjMtMC4zOTEtMS40MTQsMHMtMC4zOTEsMS4wMjMsMCwxLjQxNGwyLjE2MSwyLjE2MSAgIEMxNC42NjEsMjAuNTY0LDEzLjYzNSwyMSwxMi41LDIxeiIgZmlsbD0iI0ZGRkZGRiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
					</div>
					<p>Video</p>
				</div>
			</div>
			<div class="level-item has-text-centered">
				<div>
					<div>
						<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ2Ny4yIDQ2Ny4yIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NjcuMiA0NjcuMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI2NHB4IiBoZWlnaHQ9IjY0cHgiPgo8Zz4KCTxwYXRoIGQ9Ik00NjcuMiwyMzUuN2MwLTYyLjQtMjQuMy0xMjEuMS02OC40LTE2NS4yUzI5NiwyLjEsMjMzLjYsMi4xUzExMi41LDI2LjQsNjguNCw3MC41UzAsMTczLjMsMCwyMzUuN3YxMTAuNiAgIGMwLDYyLjUsNTAuOSwxMTMuNCwxMTMuNCwxMTMuNGM3LjUsMCwxMy41LTYsMTMuNS0xMy41VjI0Ni41YzAtNy41LTYtMTMuNS0xMy41LTEzLjVjLTM0LjYsMC02NS42LDE1LjUtODYuNCw0MHYtMzcuMyAgIGMwLTExMy45LDkyLjctMjA2LjYsMjA2LjYtMjA2LjZzMjA2LjYsOTIuNywyMDYuNiwyMDYuNmMwLDAuOSwwLjEsMS44LDAuMywyLjdjLTAuMiwwLjktMC4zLDEuOC0wLjMsMi43djM3LjMgICBjLTIwLjgtMjQuNS01MS44LTQwLTg2LjQtNDBjLTcuNSwwLTEzLjUsNi0xMy41LDEzLjV2MTk5LjdjMCw3LjUsNiwxMy41LDEzLjUsMTMuNWM2Mi41LDAsMTEzLjQtNTAuOSwxMTMuNC0xMTMuNFYyNDEuMSAgIGMwLTAuOS0wLjEtMS44LTAuMy0yLjdDNDY3LjEsMjM3LjUsNDY3LjIsMjM2LjYsNDY3LjIsMjM1Ljd6IE05OS44LDI2MXYxNzAuNmMtNDEuMi02LjUtNzIuOS00Mi4zLTcyLjktODUuMyAgIEMyNywzMDMuMyw1OC42LDI2Ny41LDk5LjgsMjYxeiBNMzY3LjQsNDM3VjI2Ni40YzQxLjIsNi41LDcyLjksNDIuMyw3Mi45LDg1LjNDNDQwLjIsMzk0LjgsNDA4LjYsNDMwLjUsMzY3LjQsNDM3eiIgZmlsbD0iI0ZGRkZGRiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
					</div>
					<p>Audio</p>
				</div>
			</div>
		</div>
		@if(Auth::user())
			<a href="{{ route('new_portfolio') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-white big-action-button">Share your work today</a>
		@else
			<a href="{{ route('register') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-white big-action-button">Sign up today</a>
		@endif
	</div>
</div>

<div class="section is-medium">
	<div class="container">
		@include('includes.top-users', ['title'=>'🏅Connect with other creative people'])
	</div>
</div>

<!-- <section class="section is-light">
	<div class="container">
		<div class="columns is-centered">
			<div class="column">
				<figure class="image">
					<img src="{{ asset('images/showcase-work.jpg') }}" alt="Showcase your creative work with ease">
				</figure>
			</div>
			<div class="column is-7">
				<h2 class="title is-3 is-size-4-mobile bold">Showcase your creative work with ease.</h2>
				<p>
					We have made it easier to upload your creative works with ease. Be more expressive by uploading your works in Video, Audio or Image format.
				</p>
				<p>
					You can mix it and spice it up however you want to, just be bold and expressive.
				</p>
				<p><strong><a href="/" target="_blank">See what others have shared</a></strong></p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>
		</div>
	</div>
</section>
<section class="section is-medium is-light">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-7">
				<h2 class="title is-3 is-size-4-mobile bold">Got something to say? Try our free blog and grow your email subscription list.</h2>
				<p>Talk about your passion, interests, business or whatever you want with our free blogging tool. Be more expressive and creative with words.</p>
				<p>Our embedded email subscription form helps you grow your subscribers with ease and you can export your list whenever you feel like.</p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>
			<div class="column">
				<figure class="image">
					<img src="{{ asset('images/blog-section.jpg') }}" alt="Try our free blog and grow your subscription list">
				</figure>
			</div>
		</div>
	</div>
</section> -->

<section class="section is-medium is-dark subu">
	<div class="container">
		<div class="columns is-centered">			
			<div class="column is-7 has-text-centered">
				<h2 class="title is-3 is-size-5-mobile bold">Lots of skills to choose from</h2>
				<p>From Makeup Artist to Photographer, Video Editor, Graphics Designer, Fashion Designer, Content Writers etc., You name it, we've got you covered.</p>
				<a href="{{ route('register') }}" class="button is-primary big-action-button">Sign up today</a>
			</div>

		</div>
	</div>
</section>

<section class="section is-medium">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-7 has-text-centered">
				<figure class="image" style="margin-bottom: 2em;">
					<img src="{{ asset('images/ubanji-community.jpg') }}" alt="Ubanji Creative">
				</figure>
				<h2 class="title is-3 is-size-5-mobile bold">Be Creative . Be Inspired . Be Ubanji</h2>
				<p>Share your work, your stories and your journey. Inspire others and be inspired, this is the value we give as a community.</p>
				@if(Auth::user())
					<a href="{{ route('new_portfolio') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Share your work today</a>
				@else
					<a href="{{ route('register') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Sign up today</a>
				@endif
			</div>
		</div>
	</div>
</section>

@include('includes.signup-teaser')
@endsection