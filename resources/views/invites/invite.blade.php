@component('mail::message')
# Hi,

**{{ $invitee_name }}** believes {{config('app.name')}} might be a good platform for you to showcase your skills and find amazing talents in Nigeria.

Join **{{ $invitee_name }}** and other professionals already using {{config('app.name')}} to promote their work, hire talents and meet new clients in Nigeria.

@component('mail::button', ['url' => $url])
Accept My Invitation :)
@endcomponent

@endcomponent
