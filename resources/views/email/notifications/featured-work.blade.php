@component('mail::message')
# {{ $fname }}, We loved your work so much we decided to tag it as *featured* on {{ config('app.name') }}!

![{{ $title }}]({{$thumbnail}})
##{{ $title }}

@component('mail::button', ['url' => $url])
View your featured work
@endcomponent

We hope more people find your work and increase your chances of getting hired.

Continue to share samples of your amazing work.

@component('mail::button', ['url' => $share])
Share more work!
@endcomponent

##{{ config('app.name') }} Team
@endcomponent
