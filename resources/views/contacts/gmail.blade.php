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
        <div>
        	<div class="text-center" style="margin-bottom: 2em">
	            <h3>Hi {{ $invitee_name }}, you are almost done!</h3>
	            <p>We found <strong>{{ $total_contacts }}</strong> contacts, please select the contacts you will like to invite</p>
            </div>
			
			<form action="/invite/gmail" method="post" class="col-md-10 col-md-offset-1">
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
					<button class="btn btn-success pull-left" type="submit"><i class="fa fa-envelope"></i> Send Invitation</button>
					<a href="/invite" class="btn btn-basic pull-right"><i class="fa fa-arrow-left"></i> Back</a>
				</div>
			</form>
        </div>
    </div>

@endsection