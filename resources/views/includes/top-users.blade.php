<div>
	<h3 class="title is-3 bold has-text-centered bold">{{ $title }}</h3>
	<div class="slick-js">
		@each('profile.person', $profiles, 'profile')
	</div>
	@if( !Auth::user() )
		 <div class="hero">
		 	<div class="hero-body has-text-centered">
		 		<a href="/register" class="button is-primary big-action-button"><span>Sign up today</span></a>
		 	</div>		     
		 </div>
	@endif
</div>