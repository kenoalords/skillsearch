@component('mail::message')
# Hi {{$fullname}}

Your contact request have been approved by {{$username}}.

You can now reach {{$username}} on the following phone number.

#{{$phone}}

Thank you for using [{{config('app.name')}}]({{config('app.url')}}) to source for creative people in Nigeria.

Regards,<br>
##{{ config('app.name') }} Team
@endcomponent
