@component('mail::message')
# Hi {{$fullname}}

Your job posting **{{$task->title}}** has been rejected, please view the reason below.

> ##{{$message}}

@component('mail::button', ['url' => config('app.url').'/profile/jobs'])
Login and make changes
@endcomponent

Thanks,<br>
###{{ config('app.name') }}
@endcomponent
