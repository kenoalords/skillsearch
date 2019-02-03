@component('mail::message')
#{{ $blog->user->profile->first_name }} 🎉 

You have a new subscriber to your blog.

##Total subscribers: {{ $count }}

Keep sharing more great content and watch your subscribers grow.

@component('mail::button', ['url' => route('blog') ])
Login to your blog
@endcomponent

##{{ config('app.name') }}
@endcomponent
