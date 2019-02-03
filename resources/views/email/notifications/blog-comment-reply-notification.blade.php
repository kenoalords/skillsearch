@component('mail::message')
#Hello {{ $comment->user->profile->first_name }},

{{ $user->profile->first_name }} replied to a comment you shared on **[{{ $blog->title }}]({{ $url }})**

>{{ $reply->comment }}

@component('mail::button', ['url' => $url])
Reply to comment
@endcomponent

##{{ config('app.name') }}
@endcomponent
