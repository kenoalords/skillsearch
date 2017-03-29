@component('mail::message')
# Hi {{$name}}

We couldn't verify your profile identity using the file you uploaded, review the reason below

> **Reason**
> {{$message}}

Please fix the error and submit a new request.

@component('mail::button', ['url' => $url])
Click here to login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
