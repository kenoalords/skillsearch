@component('mail::message')
# Hi {{$fullname}}

Congratulation! Your job **[{{ $task->title }}]({{$url}})** has been approved.

We will notify you once you start receiving applications. 

Don't forget to also share your job on social media to increase your job position on {{ config('app.name') }}.

Best Regards<br>
##{{ config('app.name') }}
@endcomponent
