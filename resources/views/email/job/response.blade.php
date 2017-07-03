@component('mail::message')
# Hi {{$receiver}}

**{{ $sender }}** responded to an application on **[{{$task->title}}]({{ route('task', ['task'=>$task->id, 'slug'=>$task['slug']]) }})**.

>{{$application->application}}

@component('mail::button', ['url' => config('app.url').'/login'])
Login to view
@endcomponent

Thanks,<br>
##{{ config('app.name') }}
@endcomponent
