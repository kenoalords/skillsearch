@component('mail::message')
# Hi {{$sender}}

##{{$name}}'s contact was requested successfully.

You will be notified once your request is approved by {{$name}}.

Thank you for using **{{ config('app.name') }}** to source for your creative talents.

Regards,<br>
##{{ config('app.name') }} Team
@endcomponent
