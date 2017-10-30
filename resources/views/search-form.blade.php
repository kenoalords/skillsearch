<form action="/search" method="get" class="ui centered form container grid" id="searchform" style="margin-top: 0;">
	<div class="">
		<div class="inline  fields">
			<div class="sixteen wide mobile field">
				<input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
			</div>
			<div class="sixteen wide mobile field">
				<input type="text" name="location" id="geolocation" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
			</div>
			<div class="sixteen wide mobile field">
				<button type="submit" class="ui button green icon labeled"><i class="icon search"></i> Search</button>
			</div>
		</div>
	</div>
</form>
