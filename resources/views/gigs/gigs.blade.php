@extends('layouts.app')

@section('title', 'Buy a gig')

@section('content')
    <div class="ui container grid" style="margin-bottom: 4em">
    		<div class="four wide computer column">
    			<form action="" class="ui form">
    				<div class="ui segment">
    					<h4 class="ui header">
    						Filter Gigs
    					</h4>
    					<div class="field">
    						<select name="category" id="" class="ui select dropdown">
    							<option value="">Select</option>
    							<option value="">One</option>
    							<option value="">Two</option>
    						</select>
    					</div>
    					<div class="field">
    						<input type="text" placeholder="Location e.g Lagos">
    					</div>
    					<div class="two fields">
    						<!-- <label>Price range</label> -->
    						<div class="field">
    							<input type="number" name="min" placeholder="Min price">
    						</div>
    						<div class="field">
    							<input type="number" name="max" placeholder="Max price">
    						</div>
    					</div>
    					<div class="field">
    						<button type="submit" class="ui fluid green button">
    							<i class="icon search"></i>Refine search
    						</button>
    					</div>
    				</div>
    			</form>
    		</div>
    		<div class="twelve wide computer column">
    			<div class="ui grid">
    				@each('gigs.includes.gig', $gigs, 'gig')
    			</div>
    		</div>
    </div>
@endsection