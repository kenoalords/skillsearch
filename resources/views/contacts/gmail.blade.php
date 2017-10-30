@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Invite Your Friends')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
<div class="ui centered container grid">
    <div class="sixteen wide mobile ten wide tablet eight wide computer column white-boxed">
        <div class="ui left aligned">
        	<div class="" style="margin-bottom: 2em">
	            <h1 class="ui header">
	            	Hi {{ $invitee_name }}
	            	<div class="sub header">We found <strong>{{ count($emails) }}</strong> contacts.</div>
	            </h1>
            </div>
			<div class="ui divider"></div>
            @if(count($friends) > 0)
            	<h4 class="ui header">We found {{count($friends)}} of your {{str_plural('friend', count($friends))}} already using {{config('app.name')}}. Connect with them now</h4>
            	<div class="ui divided items">
            		@foreach($friends as $friend)
            		<div class="item">
            			<div class="ui image">
	            			<a href="/{{$friend->name}}" target="_blank">
	        					<img src="{{$friend->profile->getAvatar()}}" alt="{{$friend->profile->getFullname()}}" class="ui avatar image">
	        				</a>
	        			</div>
            			<div class="middle aligned content">
            				<a href="/{{$friend->name}}" target="_blank" class="ui small header">{{$friend->profile->getFullname()}}</a>
            				<follow username="{{$friend->name}}" class="right floated"></follow>
            			</div>
            		</div>
            		@endforeach
            	</div>
            @endif
			
			@if(count($emails) > 0)
			<h4 class="ui header">Invite to connect</h4>
			@endif
			<form action="/invite/gmail" method="post">
				{{ csrf_field() }}
	            <input type="hidden" name="invitee_name" value="{{$invitee_name}}">
				<input type="hidden" name="invitee_email" value="{{$invitee_email}}">
				<div id="form-invite-wrapper" class="ui form" style="margin-bottom: 1em">
		            <table class="ui basic very compact striped table">
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
					<button class="ui icon labeled green button" type="submit" id="google-invite"><i class="icon send"></i> Send Invite</button>
				</div>
			</form>
        </div>
    </div>
</div>
@endsection