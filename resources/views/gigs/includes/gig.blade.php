<div class="five wide column">
	<div class="ui fluid gig card">
		<div class="image">
			<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}">
				<img src="{{ $gig['image'] }}" alt="I will {{ $gig['title'] }}" class="ui fluid image">
			</a>
		</div>
		<div class="content">
			<div class="user" style="margin-bottom: 10px;">
				<a href="{{ $gig['user']['username'] }}">
					<img src="{{ $gig['user']['avatar'] }}" alt="{{ $gig['user']['fullname'] }}" class="ui avatar image"> <small class="semi-bold">{{ $gig['user']['fullname'] }}</small>
				</a>
			</div>
			<div class="header">
				<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}">
					I will {{ $gig['title'] }}
				</a>
			</div>
		</div>
		<div class="extra content">

			<div class="right floated">
				<a href="{{ route('gig', [ 'gig'=>$gig['uid'], 'slug'=>$gig['slug'] ]) }}" class="ui icon circular mini green button" data-tooltip="Buy this gig"><i class="icon cart"></i></a>
			</div>
			<h4 class="ui green header" style="margin-top:0px">
				<span class="naira">{{ number_format( $gig['sale_price'] ) }}</span>
				@if($gig['regular_price'])
					<small class="sub header currency naira">
						<del>{{ number_format( $gig['regular_price'] ) }}</del>
					</small>
				@endif
			</h4>
		</div>
	</div>
</div>