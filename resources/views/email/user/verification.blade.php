@component('mail::message')
# Hi {{$name}}

Please click below to verify your email address.

@component('mail::button', ['url' => $key])
Verify My Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
