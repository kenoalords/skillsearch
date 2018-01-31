<div>
	<h4 class="title is-4 has-text-centered" style="letter-spacing: 2px">{{ strtoupper($title) }}</h4>
	<div class="slick-js">
		@each('profile.person', $profiles, 'profile')
	</div>
	@if( !Auth::user() )
		 <div class="hero">
		 	<div class="hero-body has-text-centered">
		 		<a href="/register" class="button is-primary"><span>Sign up now</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a>
		 	</div>		     
		 </div>
	@endif
</div>