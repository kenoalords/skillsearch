<form action="/search" method="get" id="searchform" style="margin-top: 0;">
	<div>
		<div class="field is-grouped">
			<div class="control is-expanded">
				<input type="text" name="term" class="input" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
			</div>
			<div class="control is-expanded">
				<input type="text" name="location" id="geolocation" class="input" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
			</div>
			<div class="control">
				<button type="submit" class="button is-dark">
					<span class="icon"><i class="fa fa-search"></i></span>
					<!-- <span>Go</span> -->
				</button>
			</div>
		</div>
	</div>
</form>
