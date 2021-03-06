@component('mail::message')
![Connect your Instagram Account]({{asset('public/instagram-mail-image.jpg')}} "Connect Your Instagram Account")

# Hi {{ $user->profile->first_name }}

We know everyone loves to showcase their works on Instagram and that's why we are introducing **Instagram Feeds** as part of the ways to help you showcase more of your work on {{config('app.name')}}.

Login to your account and connect your Instagram account today.

@component('mail::button', ['url' => config('app.url') . '/profile/portfolio/instagram' ])
Connect your Instagram account
@endcomponent

Thanks,<br>
## {{config('app.name')}}
@endcomponent
