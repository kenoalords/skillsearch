@component('mail::message')

## Hi {{ $name }}

 {{ $like_name }} liked your portfolio **[{{ $title }}]({{ $url }})**

 To see how many people like your portfolio, visit your portfolio on [{{config('app.name')}}]({{config('app.url')}})

@component('mail::button', ['url' => $url])
Click to view
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
