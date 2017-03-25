<form action="/search" method="get" class="row" id="search-form">
	<div class="row">
		<div class="col-md-5">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	            <input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
			</div>
		</div>
		<div class="col-md-5">
			<div class="input-group">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
	            <input type="text" name="location" id="geolocation" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
	        </div>
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-search"></i> Find People</button>
		</div>
	</div>
</form>
