<div class="ui container grid">
    <div class="sixteen wide column">
        <div class="ui items">
            <div class="middle aligned item">
                <div class="ui tiny image">
                    <a href="{{ route('view_profile', [ 'user'=>$profile['username'] ]) }}">
                        <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="ui avatar" width="100" height="100">
                    </a>
                </div>
                <div class="content">
                    <h5 class="ui header">
                        <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                            {{ ucwords(strtolower($profile['fullname'])) }} {!! identity_check($profile['verified']) !!}
                        </a>
                    </h5>
                    <div class="meta">
                        <i class="icon marker"></i> {{ $profile['location'] }}
                    </div>
                    <div class="description">
                        <p>{{ str_limit($profile['bio'], 75) }}</p>
                        
                    </div>
                    @if(count($profile['skills']) > 0)
                        <div class="extra">
                            @foreach ($profile['skills'] as $skill)
                                <a href="/search/?term={{ $skill['skill'] }}" class="ui mini teal basic label">{{ $skill['skill'] }}</a>
                            @endforeach
                        </div>
                    @endif
                    
                </div>
                <div class="right floated">
                    <follow username="{{$profile['username']}}"></follow>
                </div>
            </div>
        </div>
    </div>
</div>
