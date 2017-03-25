@if($profile->account_type == true)
<div class="col-sm-12" id="person-tag">
    <div class="media">
        <div class="media-left">
            <a href="{{ route('view_profile', ['user'=>$profile->user->name]) }}">
                <img src="{{ $profile->getAvatar() }}" alt="{{ $profile->first_name }} {{ $profile->last_name }}" class="media-object img-circle" width="100" height="100">
            </a>
        </div>

        <div class="media-body">
            <h4 class="media-heading">
                <a href="{{ route('view_profile', ['user'=>$profile->user->name]) }}">
                    {{ $profile->first_name }} {{ $profile->last_name }} {!! identity_check($profile->identity) !!}
                </a>
            </h4>
            {!! getRatings($profile->rating) !!}
            @if($profile->skills->count())
            <div>
                @foreach ($profile->skills as $skill)
                    <small class="label label-default">{{ $skill->skill }}</small>
                @endforeach
            </div>
            @endif
            <p>{{ str_limit($profile->bio, 150) }}</p>
            
            <ul class="profile-meta">
                <li><i class="glyphicon glyphicon-map-marker"></i> {{ $profile->location }}</li> 
                <li><i class="glyphicon glyphicon-briefcase"></i> {{$profile->portfolio_count}} {{str_plural('Portfolio', $profile->portfolio_count)}}</li>
            </ul>            
        </div>
    </div>
</div>
@endif