@component('mail::message')
# Cron Test

This is a test email from cron.

@component('mail::button', ['url' => 'http://google.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
