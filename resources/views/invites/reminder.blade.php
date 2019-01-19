@component('mail::message')
# Hello there,

We are still waiting for you to accept **{{ $invitee_name }}** invitation to join **{{config('app.name')}}**.

We are building the biggest creative community in Nigeria and **{{ $invitee_name }}** wants you to be a part of it.

**{{config('app.name')}}** is a community of creative and skilled people seeking new opportunities. Join **{{ $invitee_name }}** and other people already using **{{config('app.name')}}** to promote their works and invite your friends to join in too.

@component('mail::button', ['url' => $url])
Accept My Invitation :)
@endcomponent

**{{config('app.name')}} Team!** 

If you do not want receive future reminders from **{{$name}}**, [please click here]({{$unsubscribe}})
@endcomponent
