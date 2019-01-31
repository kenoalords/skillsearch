<div class="column is-one-third-desktop is-one-quarter-widescreen is-half-tablet">
    <div class="card user">
        <div class="card-content has-text-centered ">
            <div>
                <a href="{{ route('view_profile', [ 'user'=>$profile['username'] ]) }}">
                    <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="image is-96x96" width="100" height="100">
                </a>
            </div>
            <div class="content">
                <h4 class="title is-6">
                    <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}" class="{{ ($profile['verified']) ? 'verified' : '' }}">
                        {{ ucwords(strtolower($profile['fullname'])) }}
                    </a>
                    
                </h4>
                @if($profile['location'])
                    <div class="subtitle is-6 is-spaced" style="margin-top: -1.8em;">{{ $profile['location'] }}</div>
                @endif
                @if(count($profile['skills']) > 0)
                    {!! formatSkills($profile['skills']) !!}
                @endif
            </div>
        </div>
        <!-- <div class="card-footer">
            <a href="/{{$profile['username']}}" class="card-footer-item">View profile</a>
        </div> -->
    </div>
</div>
