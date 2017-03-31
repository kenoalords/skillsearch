@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="https://s3.amazonaws.com/images.skillsearch.com.ng/public/logo-b.png" alt="Skillsearch Nigeria Logo">
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
            [![Follow us on Twitter](https://s3.amazonaws.com/images.skillsearch.com.ng/public/twitter.png)](https://twitter.com/skillsearchng)
            [![Follow us on Facebook](https://s3.amazonaws.com/images.skillsearch.com.ng/public/facebook.png)](https://facebook.com/skillsearchng)
            [![Follow us on Google](https://s3.amazonaws.com/images.skillsearch.com.ng/public/google.png)](https://plus.google.com/skillsearchng)
            
            {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
