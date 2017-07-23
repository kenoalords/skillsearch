@component('mail::message')

# Find the best {{$term[1]}} for your projects today and achieve more quickly.

@component('mail::profile', ['profiles'=>$profiles])
@endcomponent

Browse over **3,622** skilled people and jobs on [{{config('app.name')}}]({{config('app.url')}}) for Free!

@component('mail::button', ['url' => $url, 'color'=>'green'])
Find More {{$term[1]}}
@endcomponent

Join [{{config('app.name')}}]({{config('app.url')}}) to submit your projects and hire only the best. It's free to use

@endcomponent
