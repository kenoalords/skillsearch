@component('mail::message')

## Hi {{ $name }}

 You have a response to the following service request: **{{ $subject }}**

 Please login to your account to read and respond.

@component('mail::button', ['url' => $url])
View request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
