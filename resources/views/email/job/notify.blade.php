@component('mail::message')
# Hi {{$name}}

We found a new job you might be interested in;

> #[{{$task->title}}]({{$url}})
> {{str_limit($task->description)}}
@if($task->budget)
># Budget: {{$task->budget}}
@endif

@component('mail::button', ['url' => $url])
Respond to this job
@endcomponent

Best Regards<br>
##{{ config('app.name') }}
@endcomponent
