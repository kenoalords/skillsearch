@component('mail::message')
# Hi {{ $user }}

{{$request_name}} requested for your contact details via {{config('app.name')}}.

If you will like {{$request_name}} to contact you, please click approve below.

Please note that we will **ONLY** send your phone number to {{$request_name}} once this request is approved.

@component('mail::button', ['url' => $url, 'color' => 'green'])
Login to approve
@endcomponent

**P.S. If you are yet to set up your contact number on {{ config('app.name') }}, kindly set it up first before approving this request.**

Regards,<br>
##{{ config('app.name') }} Team
@endcomponent
