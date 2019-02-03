@component('mail::message')
# Hello {{ $comment->user->profile->first_name }},

{{ $user->profile->first_name }} liked your comment on **[{{ $blog->title }}]({{ $url }})**.

>{{ $comment->comment }}

##{{ config('app.name') }}
@endcomponent
