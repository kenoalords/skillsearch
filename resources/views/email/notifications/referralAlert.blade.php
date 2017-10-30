@component('mail::message')
# Congrats {{ $user }}!

**[{{ $fullname }}]({{$url}})** signed up on {{ config('app.name') }} using your referral code.

Thank you for helping to grow our awesome community.

@component('mail::button', ['url' => $url])
View {{ $fullname }}'s Profile
@endcomponent

##{{ config('app.name') }}
@endcomponent
