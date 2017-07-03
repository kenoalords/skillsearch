@component('mail::message')
# We found some jobs on {{config('app.name')}} you might be interested in.
@if(count($tasks) > 0)
@foreach($tasks as $task)
> ## [{{$task['title']}}]({{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }})
> {{ $task['excerpt'] }}
> ### Budget: ₦{{ $task['human_budget'] }}, Location: {{ $task['location'] }}
@endforeach
@endif

@component('mail::button', ['url' => '' ])
View all jobs
@endcomponent

P.S. You can share these jobs with your friends and get them to apply on {{config('app.name')}}

Best Regards,<br>
## {{config('app.name')}}
@endcomponent
