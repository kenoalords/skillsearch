@component('mail::message')
# Howdy!

>##Reminder: {{$name}} invited you to connect on {{config('app.name')}}

Join **{{$name}}** and other professionals already using {{config('app.name')}} to promote their works, hire talents and meet new clients in Nigeria.

@component('mail::button', ['url' => $url])
Please Accept My Invitation :)
@endcomponent

Thanks<br>
###{{config('app.name')}}

If you do not want receive future reminders from **{{$name}}**, [please click here]({{$unsubscribe}})
@endcomponent
