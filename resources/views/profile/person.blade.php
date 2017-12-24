<div class="ui center aligned segment">
    <div>
        <a href="{{ route('view_profile', [ 'user'=>$profile['username'] ]) }}">
            <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="ui centered circular image" width="100" height="100" style="margin: 2em auto; border: 5px solid #eee">
        </a>
    </div>
    <div class="content" style="padding-bottom: 2em">
        <h4 class="ui centered header">
            <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                {{ ucwords(strtolower($profile['fullname'])) }} {!! identity_check($profile['verified']) !!}
            </a>
            @if($profile['location'])
                <div class="sub header"><i class="icon marker" style="margin-right: 0"></i>{{ $profile['location'] }}</div>
            @endif
        </h4>
        
        @if(count($profile['skills']) > 0)
            {!! formatSkills($profile['skills']) !!}
        @endif
        <p><a href="/{{$profile['username']}}/contact-request" class="ui tiny icon label"><i class="icon mail"></i>Request Contact</a></p>
    </div>
</div>
