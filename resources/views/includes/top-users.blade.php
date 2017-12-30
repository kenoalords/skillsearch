<div class="sixteen wide computer column">
	<h4 class="ui centered grey header" style="letter-spacing: 2px">{{ strtoupper($title) }}</h4>
	<div class="slick-js">
		@each('profile.person', $profiles, 'profile')
	</div>
	@if( !Auth::user() )
		 <div class="ui centered grid" style="margin-top: 3em">
		     <a href="/register" class="ui green button">Sign up now <i class="icon arrow right"></i></a>
		 </div>
	@endif
</div>