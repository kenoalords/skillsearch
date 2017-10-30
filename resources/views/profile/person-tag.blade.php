<div class="ui container grid">
    <div class="sixteen wide tablet six wide computer column">
        <div class="ui unstackable items">
            <div class="item">
                <div class="ui tiny image">
                    <a href="{{ route('view_profile', [ 'user'=>$profile['username'] ]) }}">
                        <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="ui avatar" width="100" height="100">
                    </a>
                </div>
                <div class="content">
                    <h3 class="ui header">
                        <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                            {{ ucwords(strtolower($profile['fullname'])) }} {!! identity_check($profile['verified']) !!}
                        </a>
                    </h3>
                    <div class="meta">
                        <i class="icon marker"></i> {{ $profile['location'] }}
                    </div>
                    <div class="description large-screen-only">
                        <p>{{ str_limit($profile['bio'], 75) }}</p>
                        
                    </div>
                    @if(count($profile['skills']) > 0)
                        <div class="extra">
                            <!-- <h5>Skills</h5> -->
                            @foreach ($profile['skills'] as $skill)
                                <a href="/search/?term={{ $skill['skill'] }}" class="ui mini teal basic label">{{ $skill['skill'] }}</a>
                            @endforeach
                        </div>
                    @endif
                    <div class="ui divider"></div>
                    <a href="/{{$profile['username']}}/contact-request" class="ui tiny icon label"><i class="icon mail"></i>Request Contact</a>
                    @if($profile['has_instagram'] === true)
                        <a href="/{{$profile['username']}}/instagram" class="ui tiny teal icon label"><i class="icon instagram"></i><span class="bold">Instagram</span> <span class="thin">Feed</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="ten wide computer only column">
        @if(count($profile['portfolios']) > 0)
            <div class="ui three column grid">
                @each('includes.portfolio-without-user', $profile['portfolios'], 'portfolio')
            </div>
        @endif
    </div>
</div>
