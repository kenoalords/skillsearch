@component('mail::message')
# Hi {{ $name }}

You are yet to verify your account on {{ config('app.name') }}.

Please click below to verify your account

@component('mail::button', ['url' => $url])
Verify My Account Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
