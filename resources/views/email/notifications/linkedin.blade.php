@component('mail::message')
@if($contact->first_name)
# Hi {{ $contact->first_name }},
@endif

Hiring can be time consuming and expensive and often times Organizations and Entrepreneurs miss the crucial details when hiring a new member that fits in best with your team.

Whether you are hiring for short-term or long-term projects, knowing who matches your requirements the most is a huge time saver.

![Help is a click away]({{asset('public/help-banner.jpg')}})

On [{{config('app.name')}}]({{$url}}), hundreds of professionals in Nigeria with diverse skills are uploading and updating their portfolios making it easy for you to hire.

From [Photographers](http://bit.ly/2tNbWti) to [Makeup Artists](http://bit.ly/2uRlxPU), [Event Planners](http://bit.ly/2tIgbbn), [Copywriters](http://bit.ly/2teiqQ5), [Film Makers](http://bit.ly/2uiHeLZ), [Web Designers](http://bit.ly/2vcsYRm), [Graphics Designer](http://bit.ly/2tIOnUj) and [lots more]({{$url}}), you can find a new hand for hire from the comfort of your home or office.

@component('mail::button', ['url' => $url])
Find the best hands now
@endcomponent

Regards,<br>
### Adedeji Stevens via {{ config('app.name') }}
@endcomponent
