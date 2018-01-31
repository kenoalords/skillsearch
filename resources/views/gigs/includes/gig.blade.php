<div class="column is-3">
	<div class="card portfolio">
		<div class="card-image">
			<figure class="image">
				<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}">
					<img src="{{ $gig['image'] }}" alt="I will {{ $gig['title'] }}" >
				</a>
			</figure>
		</div>
		<div class="card-content">
			<a href="{{ $gig['user']['username'] }}" class="author">
				<img src="{{ $gig['user']['avatar'] }}" alt="{{ $gig['user']['fullname'] }}" class="image is-24x24 is-rounded is-inline"> <span style="position: relative; top: -5px">{{ $gig['user']['fullname'] }}</span>
			</a>
			<h3 class="title is-5">
				<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}" class="has-text-dark">
					I will {{ $gig['title'] }}
				</a>
			</h3>
			<div class="level is-mobile">
			<div class="level-left">
				<div class="level-item">
					<div>
						<h4 class="is-size-4 has-text-success">
							<span class="naira">{{ number_format( $gig['sale_price'] ) }}</span>
						</h4>
						@if($gig['regular_price'])
							<h4 class="subtitle is-7">
								<del class="naira">{{ number_format( $gig['regular_price'] ) }}</del>
							</h4>
						@endif
					</div>
				</div>
			</div>
			<div class="level-right">
				<div class="level-item">
					<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}" class="button is-primary is-circle" data-tooltip="Buy this gig"><span class="icon"><i class="fa fa-shopping-basket"></i></span></a>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>