@component('mail::message')
# Hi {{$owner}}

{{$name}} replied to a comment you posted on [{{$portfolio->title}}]({{$url}}).

@component('mail::button', ['url' => $url])
View Reply
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
