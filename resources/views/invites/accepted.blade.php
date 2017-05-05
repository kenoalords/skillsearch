@component('mail::message')
# Hi {{ $sender_name }},

**[{{$receiver_name}}]({{$url}})** accepted your invitation to [{{config('app.name')}}]({{config('app.url')}}).

@component('mail::button', ['url' => $url])
Connect with {{$receiver_name}}
@endcomponent

@endcomponent
