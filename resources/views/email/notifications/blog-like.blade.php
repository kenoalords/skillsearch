@component('mail::message')
# Hello {{ $owner }}

{{ $name }} likes your blog post [{{ $blog->title }}]({{ $url }}).

##Total likes: {{ $count }}

@component('mail::button', ['url' => $url ])
View blog post
@endcomponent

##{{ config('app.name') }} Team
@endcomponent
