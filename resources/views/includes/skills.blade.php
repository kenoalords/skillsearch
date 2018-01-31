<div class="hero is-light">
	<div class="hero-body">
		<div class="columns is-centered">
			<div class="column is-10">
				<h4 class="title is-4">Popular Skill</h4>
				<ul class="skills-list" style="padding: .6em;">
					@foreach($skills as $skill)
					<li>
						<a href="/search/?term={{urlencode(trim($skill->skill))}}">{{str_limit($skill->skill,20)}}</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>