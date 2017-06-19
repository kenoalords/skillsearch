@component('mail::message')
# Hi {{ $user->profile->first_name }}

{{$applicant->profile->first_name}} applied for your job **[{{ $task->title }}]({{$url}})** on {{ config('app.name') }}

@component('mail::button', ['url' => $url])
Login to view application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
