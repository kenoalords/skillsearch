<div class="padded">
	<div class="ui container">
		<h4 class="ui header" style="text-transform: uppercase; letter-spacing: 2px">Popular Skill</h4>
		<!-- <div class="ui divider" style="margin-bottom: 1em"></div> -->
		<div class="ui six column doubling grid" style="padding: .6em;">
			@foreach($skills as $skill)
			<div class="column" style="padding: .5em;">
				<a href="/search/?term={{urlencode(trim($skill->skill))}}" class="ui fluid label"><span class="detail">{{number_format($skill->count)}}</span> {{str_limit($skill->skill,20)}}</a>
			</div>
			@endforeach
		</div>
	</div>
</div>