<form action="/search" method="get" class="ui form" id="searchform" style="margin-top: 0;">
	<div class="ui centered container grid">
		<div class="fields">
			<div class="six wide field">
				<input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
			</div>
			<div class="six wide field">
				<input type="text" name="location" id="geolocation" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
			</div>
			<div class="four wide field">
				<button type="submit" class="ui button green"><i class="icon search"></i>Go</button>
			</div>
		</div>
	</div>
</form>
