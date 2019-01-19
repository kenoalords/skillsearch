<form action="/search" method="get">
	<div>
		<div class="field has-addons">
			<div class="control is-expanded">
				<input type="text" name="term" class="input" placeholder="e.g Website Desginer in Lagos" value="{{Request::get('term')}}">
			</div>
			<!-- <div class="control is-expanded">
				<input type="text" name="location" id="geolocation" class="input" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
			</div> -->
			<div class="control">
				<button type="submit" class="button">
					<span class="icon"><i class="fa fa-search"></i></span>
					<!-- <span>Search</span> -->
				</button>
			</div>
		</div>
	</div>
</form>
