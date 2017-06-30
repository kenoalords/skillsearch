<form action="/search" method="get" class="row">
	<div class="container">
		<div class="col-md-10 col-md-offset-1">
			<div class="col-md-5 search-input">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		            <input type="text" name="term" class="form-control" placeholder="e.g Website Desginer" value="{{Request::get('term')}}">
				</div>
			</div>
			<div class="col-md-5 search-input">
				<div class="input-group">
		            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
		            <input type="text" name="location" id="geolocation" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{Request::get('location')}}">
		        </div>
			</div>
			<div class="col-md-2 search-input">
				<button type="submit" class="btn btn-default btn-block"><i class="glyphicon glyphicon-search"></i> Search</button>
			</div>
		</div>
	</div>
</form>
