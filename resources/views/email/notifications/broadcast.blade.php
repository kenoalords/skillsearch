@component('mail::message')

{!! $body !!}

@if($url)
@component('mail::button', ['url' => $url])
	{{ $button_text }}
@endcomponent
@endif

Regards,<br>
{{ $sender }}
@endcomponent
