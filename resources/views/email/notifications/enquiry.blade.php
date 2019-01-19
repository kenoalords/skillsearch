@component('mail::message')
# Hello

Your have a new message enquiry from {{ $name }}.

> {{ $message }}

To reply to this email, click the reply to button provided by your email client.

Thank you for choosing {{ config('app.name') }}.

Regards,<br>
##{{ config('app.name') }} Team
@endcomponent
