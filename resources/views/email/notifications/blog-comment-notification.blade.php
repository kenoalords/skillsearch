@component('mail::message')
# {{ $blog->user->profile->first_name }}

{{ $user->profile->first_name }} commented on your blog post **[{{ $blog->title }}]({{ $url }})**

>{{ $comment->comment }}

[Click here to]({{ $url }}) reply to {{ $user->profile->first_name }}

@component('mail::button', ['url' => $url])
Reply to comment
@endcomponent

##{{ config('app.name') }}
@endcomponent
