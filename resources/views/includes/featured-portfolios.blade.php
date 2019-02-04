<div class="section is-white">
    <div class="container">
    		<h3 class="title is-3 is-size-5-mobile has-text-centered bold">See what people are sharing</h3>
		<div class="columns is-multiline is-mobile">
			@each('includes.portfolio-with-user', $portfolios, 'portfolio')
		</div>
		<div class="has-text-centered">
			@if(Auth::user())
				<a href="{{ route('new_portfolio') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Share your work today</a>
			@else
				<a href="{{ route('register') }}?utm_source=community_hero&utm_medium=hero_action&utm_campaign=hero_banner_link" class="button is-primary big-action-button">Sign up today</a>
			@endif
		</div>
    </div>
</div>

