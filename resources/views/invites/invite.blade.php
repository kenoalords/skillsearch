@component('mail::message')
# Hi,

**{{ $invitee_name }}** invites you to showcase your skills, connect and find amazing talents in Nigeria via **{{config('app.name')}}**.

Join **{{ $invitee_name }}** and other professionals already using {{config('app.name')}} to promote their works, hire talents and meet new clients in Nigeria.

@component('mail::button', ['url' => $url])
Accept My Invitation :)
@endcomponent

@endcomponent
