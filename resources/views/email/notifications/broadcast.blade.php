@component('mail::message')

@if($image_link)
![{{config('app.name')}}]({{$image_link}})
@endif

{{ $body }}

@if($url)
@component('mail::button', ['url' => $url])
	{{$button_text}}
@endcomponent
@endif

## Keno from {{ config('app.name') }}
@endcomponent
