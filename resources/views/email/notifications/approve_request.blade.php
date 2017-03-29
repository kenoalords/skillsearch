@component('mail::message')
# Hi {{$name}}

Your profile identity verification have been approved.

You now have our verification icon next to your name which will boost your profile status.

@component('mail::button', ['url' => $url])
Log in to view
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
