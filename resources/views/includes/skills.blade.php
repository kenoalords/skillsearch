<div class="section is-light">
	<div class="container">
		<h3 class="title is-5 bold">Popular Skill</h3>
		<ul class="skills-list">
			@foreach($skills as $skill)
			<li>
				<a href="/search/?term={{urlencode(trim($skill->skill))}}">{{str_limit($skill->skill,20)}}</a>
			</li>
			@endforeach
		</ul>
	</div>
</div>