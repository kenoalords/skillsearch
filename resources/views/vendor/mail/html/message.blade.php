@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{asset('public/logo-email.png')}}" alt="Skillsearch Nigeria Logo" style="width: 220px; height: auto">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @if (isset($subcopy))
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endif

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            [![Follow us on Twitter]({{asset('public/twitter-icon.png')}})](https://twitter.com/skillsearchng)
            [![Follow us on Facebook]({{asset('public/facebook-icon.png')}})](https://facebook.com/skillsearchng)
            [![Follow us on Instagram]({{asset('public/instagram-icon.png')}})](https://instagram/skillsearch)
            
            {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
