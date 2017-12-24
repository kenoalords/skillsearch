<div class="padded" id="popular-skills">
	<div class="ui container">
		<h4 class="ui centered header" style="text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2em">Popular Skill</h4>
		<!-- <div class="ui divider" style="margin-bottom: 1em"></div> -->
		<div class="ui six column doubling grid" style="padding: .6em;">
			@foreach($skills as $skill)
			<div class="column" >
				<a href="/search/?term={{urlencode(trim($skill->skill))}}">{{str_limit($skill->skill,20)}}</a>
			</div>
			@endforeach
		</div>
	</div>
</div>