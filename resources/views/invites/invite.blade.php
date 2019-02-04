@component('mail::message')
# Hello there,

**{{ $invitee_name }}** invites you to join {{config('app.name')}}.

{{config('app.name')}} is a community of creative and skilled people seeking new opportunities. Join **{{ $invitee_name }}** and other people already using **{{config('app.name')}}** to promote their works and invite your friends to join in too.

@component('mail::button', ['url' => $url])
Accept My Invitation :)
@endcomponent

**{{config('app.name')}} Team!** 
@endcomponent
