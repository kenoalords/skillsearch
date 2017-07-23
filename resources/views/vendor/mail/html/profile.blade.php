<table cellpadding="5" cellspacing="0" id="profiles" width="100%">
@foreach($profiles as $profile)
    <tr>
        <td valign="top">
            <a href="{{$profile->url}}/?utm_source=newsletter&utm_medium=email&utm_campaign=profile_promotion&utm_content=linkedin_contact"><img src="{{$profile->avatar}}" alt="" style="width: 64px; height: 64px; border-radius: 64px"></a>
        </td>
        <td>
            <h4 style="margin-bottom: 5px; margin-top: 0">
                <a href="{{$profile->url}}/?utm_source=newsletter&utm_medium=email&utm_campaign=profile_promotion&utm_content=linkedin_contact">
                    {{ $profile->fullname }}
                </a>
            </h4>
            <span>{{ $profile->location }}</span><br>
            <small><strong>{{ count($profile->portfolios) }} {{ str_plural('Portfolio', count($profile->portfolios)) }}</strong></small>
        </td>
    </tr>
@endforeach
</table>
