@component('mail::message')

{!! $body !!}

@if($url)
@component('mail::button', ['url' => $url])
	{{$button_text}}
@endcomponent
@endif

Regards<br>
##Keno Alordiah
<img src="{{ config('app.url') }}/email-broadcast?email={{ $email }}&subject={{ $sub }}">
@endcomponent
