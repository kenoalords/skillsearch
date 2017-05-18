@component('mail::message')
# Hi {{ $portfolio->user->profile->getFullname() }}

{{ $name }} posted a comment on your portfolio **[{{ $portfolio->title }}]({{$url}})**.

@component('mail::button', ['url' => $url])
View Comment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
