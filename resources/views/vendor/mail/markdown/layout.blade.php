{!! strip_tags($header) !!}

{!! strip_tags($slot) !!}
@if (isset($subcopy))

{!! strip_tags($subcopy) !!}
@endif

@if (isset($profile))
{!! $profile !!}
@endif

{!! strip_tags($footer) !!}
