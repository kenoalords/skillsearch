@extends('layouts.dashboard')
@section('title', 'Subscribers')
@section('content')

@include('includes.status')
<h1 class="title is-2 bold">Subscribers</h1>
<h4 class="subtitle">Here, you will find people who subscribed to your blog posts.</h4>
@include('blog.menu')

<div class="notification is-info">
<strong>PRO TIP:</strong> Blogging is a great way to solidify your position as an industry expert and reach a wider audience. <strong><a href="{{ route('add_blog') }}">click here to start blogging today</a></strong>
</div>

@if( $subscribers->count() )
	<form action="#">
		<table class="table is-bordered is-striped is-narrow is-hoverable">
			<thead>
				<tr>
					<th><input type="checkbox" name="checkall" id="checkall"></th>
					<th>Name</th>
					<th>Email</th>
					<th>Blog title</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $subscribers as $subscriber )
				<tr>
					<td><input type="checkbox" name="subscriber[{{ $subscriber->id }}]"></td>
					<td>{{ ucwords( strtolower($subscriber->fullname) ) }}</td>
					<td><a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a></td>
					<td>{{ $subscriber->blog_title }}</td>
					<td><span class="date">{{ $subscriber->created_at->diffForHumans() }}</span></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>
@else
	<h3 class="title is-5 has-text-danger">You don't have any subscribers yet. <a href="{{ route('add_blog') }}">Write a blog post</a></h3>
@endif

@endsection

