@extends('layouts.app')

@section('title', 'Buy a gig')

@section('content')
    <div class="hero is-dark">
        <div class="hero-body has-text-centered">
            <h1 class="title is-3">Buy services</h1>
            <h4 class="subtitle is-6">Get your job done faster with these great deals</h4>
        </div>
    </div>
    <div class="hero">
    		<div class="hero-body">
                <div class="columns is-centered">
                    <div class="column is-2">
                        <form action="" class="ui form">
                            <div class="ui segment">
                                <h4 class="title is-5">
                                    Filter Gigs
                                </h4>
                                <div class="field">
                                    <div class="select is-block">
                                        <select name="category" id="" style="width: 100%">
                                            <option>Select</option>
                                            <option value="">One</option>
                                            <option value="">Two</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <input type="text" placeholder="Location e.g Lagos" class="input">
                                </div>
                                <div class="field is-grouped">
                                    <!-- <label>Price range</label> -->
                                    <p class="control" style="width: 47%">
                                        <input type="text" name="min" placeholder="Min price" class="input">
                                    </p>
                                    <p class="control" style="width: 47%">
                                        <input type="text" name="max" placeholder="Max price" class="input">
                                    </p>
                                </div>
                                <div class="field">
                                    <button type="submit" class="button is-primary is-block">
                                        <span class="icon"><i class="fa fa-search"></i></span>
                                        <span>Refine search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="column is-10">
                        @if($gigs)
                            <div class="columns is-multiline">
                                @each('gigs.includes.gig', $gigs, 'gig')
                            </div>
                        @endif
                    </div>
                </div>  			
    		</div>
    </div>
@endsection