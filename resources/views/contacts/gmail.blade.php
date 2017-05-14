@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on skillsearch.')

@section('content')
    <div class="text-center white-boxed" style="padding: 0px">
        <img src="{{asset('public/select-contact.jpg')}}" alt="Invite your friends" style="max-width: 100%">
    </div>
    <div class="container padded">
        <div class="col-md-offset-2 col-md-8">
        	<div class="" style="margin-bottom: 2em">
	            <h2 class="thin">Hi {{ $invitee_name }}</h2>
	            <p>We found <strong>{{ count($emails) }}</strong> contacts.</p>
            </div>
			<hr>
            @if(count($friends) > 0)
            	<h4 class="thin">We found {{count($friends)}} of your {{str_plural('friend', count($friends))}} already using {{config('app.name')}}. Connect with them now</h4>
            	<div class="white-boxed" style="margin-bottom: 2em">
            		@foreach($friends as $friend)
            		<div class="media">
            			<div class="media-left">
            				<a href="/{{$friend->name}}" target="_blank">
            					<img src="{{$friend->profile->getAvatar()}}" alt="{{$friend->profile->getFullname()}}" class="media-object img-circle" width="36" height="36">
            				</a>
            			</div>
            			<div class="media-body clearfix">
            				<div class="media-heading pull-left">
            					<h5 class="bold"><a href="/{{$friend->name}}" target="_blank">{{$friend->profile->getFullname()}}</a></h5>
            				</div>
            				<div class="pull-right">
            					<follow username="{{$friend->name}}"></follow>
            				</div>
            			</div>
            		</div>
            		@endforeach
            	</div>
            @endif
			
			@if(count($emails) > 0)
			<h4 class="thin">Invite to connect</h4>
			@endif
			<form action="/invite/gmail" method="post">
				{{ csrf_field() }}
	            <input type="hidden" name="invitee_name" value="{{$invitee_name}}">
				<input type="hidden" name="invitee_email" value="{{$invitee_email}}">
				<div id="form-invite-wrapper" class="table-responsive">
		            <table class="table table-hover table-fixed">
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
		            				<td class="col-xs-2"><input type="checkbox" checked name="invite[]" value="{{$email['name']}}|{{$email['email']}}" class="email-contact"></td>
		            				<td class="col-xs-5">{{$email['name']}}</td>
		            				<td class="col-xs-5">{{$email['email']}}</td>
		            			</tr>
		            		@endforeach
		            	</tbody>
		            </table>
            	</div> <!-- end form wrapper -->
				<div class="clearfix">
					<button class="btn btn-success pull-left" type="submit" id="google-invite"><i class="fa fa-envelope"></i> Send Invitation</button>
					<a href="/invite" class="btn btn-basic pull-right"><i class="fa fa-arrow-left"></i> Back</a>
				</div>
			</form>
        </div>
    </div>

@endsection