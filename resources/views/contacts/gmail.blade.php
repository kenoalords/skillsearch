@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
<div class="hero">
    <div class="hero-body">
        	<div class="columns is-centered">
	        	<div class="column is-8">
	        		<h1 class="title is-4">Hi {{ $invitee_name }}</h1>
		          <p>We found <strong>{{ count($emails) }}</strong> contacts.</p>

		          @if(count($friends) > 0)
		            	<h4 class="title is-6">We found {{count($friends)}} of your {{str_plural('friend', count($friends))}} already using {{config('app.name')}}. Connect with them now</h4>
		            	<div class="columns is-multiline">
		            		@each('profile.person-follow-tag', $friends, 'profile')
		            	</div>
            		@endif
            		@if(count($emails) > 0)
					<h4 class="title is-4">Invite to connect</h4>
				@endif
					<form action="/invite/gmail" method="post">
					{{ csrf_field() }}
		            	<input type="hidden" name="invitee_name" value="{{$invitee_name}}">
					<input type="hidden" name="invitee_email" value="{{$invitee_email}}">
					<div id="form-invite-wrapper" class="ui form" style="margin-bottom: 1em">
			            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
			            	<thead>
			            		<tr>
			            			<th class="col-xs-2">Select</th>
			            			<th class="col-xs-5">Fullname</th>
			            			<th class="col-xs-5">Email</th>
			            		</tr>
			            	</thead>
			            	<tbody>
			            		@foreach($emails as $key => $email)
			            			<tr>
			            				<td>
			            					<div class="ui checkbox">
			            						<input type="checkbox" checked name="invite[]" value="{{$email['name']}}|{{$email['email']}}" class="email-contact">
			            					</div>
			            				</td>
			            				<td>{{$email['name']}}</td>
			            				<td>{{$email['email']}}</td>
			            			</tr>
			            		@endforeach
			            	</tbody>
			            </table>
	            		</div> <!-- end form wrapper -->
					<div class="clearfix">
						<button class="button is-primary" type="submit" id="google-invite"><i class="icon send"></i> Send Invite</button>
					</div>
				</form>
	          </div>
        	</div>
    	</div>
</div>
@endsection