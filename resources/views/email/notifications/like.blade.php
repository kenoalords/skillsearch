@component('mail::message')

## Hi {{ $name }}

 {{ $like_name }} liked your portfolio **[{{ $title }}]({{ $url }})**

 To see how many people like your portfolio, visit your portfolio on [Skillsearch Nigeria]({{config('app.url')}})

@component('mail::profile', ['url'=>'http://skillsearch.com.ng'])
@endcomponent

@component('mail::button', ['url' => $url])
Click to view
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
