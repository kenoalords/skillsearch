@component('mail::message')

## Hi {{ $reciever_name }}

 {{ $sender_name }} requested for your service in **{{ $services }}** with this message

 > **__{{ $message }}__**

 Please login to your account to respond to {{ $sender_name }}'s request.

@component('mail::button', ['url' => $url])
View request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
