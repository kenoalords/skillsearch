@component('mail::message')

## Hi {{ $name }}

 Thank you for signing up on {{ config('app.name') }}. Your registered email address is **{{ $email }}**

 Click below to activate your account

@component('mail::button', ['url' => $url])
Activate my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
