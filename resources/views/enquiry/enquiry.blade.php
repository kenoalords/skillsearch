@extends('layouts.dashboard')
@section('title', 'Enquiries')
@section('content')


<div class="section">
	<div class="columns is-centered">
		<div class="column is-7">
			<h1 class="title is-2 bold">Enquiries</h1>
			@if( $enquiry_count > 0 )
				<p>You have <span class="enquiry_count">{{$enquiry_count}} unread</span> {{$enquiry_count > 1 ? 'enquiries' : 'enquiry'}}</p>
			@else
				<p>You have no unread enquiries.</p>
			@endif

			@if( $unread->count() > 0 )
				<h4 class="title is-5 bold">Unread</h4>
				@foreach( $unread as $enquiry )
				<div class="card enquiry">
					<div class="card-content">
						<div class="level is-mobile">
							<div class="level-left">
								<div class="level-item">
									<a href="#">
										<span class="icon has-text-light"><i class="fa fa-envelope"></i></span>
										<span>{{ ucwords(strtolower($enquiry->name)) }}</span>
									</a>
								</div>
							</div>
							<div class="level-right">
								<div class="level-item">
									<span class="date">{{ $enquiry->created_at->diffForHumans() }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
	
</div>
@endsection
