<div class="col-sm-12 person-tag">
    <div class="media">
        <div class="media-left">
            <a href="{{ route('view_profile', [ 'user'=>$profile['username'] ]) }}">
                <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="media-object img-circle" width="100" height="100">
            </a>
        </div>

        <div class="media-body">
            <div class="container-fluid row">
                <div class="col-md-3">
                    <h4 class="media-heading">
                        <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                            {{ $profile['fullname'] }} {!! identity_check($profile['verified']) !!}
                        </a>
                    </h4>
                   <ul class="profile-meta">
                        <li><i class="glyphicon glyphicon-map-marker"></i> {{ $profile['location'] }}</li> 
                    </ul> 
                    @if(count($profile['skills']) > 0)
                    <div>
                        @foreach ($profile['skills'] as $skill)
                            <small class="label label-default">{{ $skill['skill'] }}</small>
                        @endforeach
                    </div>
                    @endif
                    <p>{{ str_limit($profile['bio'], 75) }}</p>
                    <p>
                        <a href="/{{$profile['username']}}" class="btn btn-default btn-xs">View profile</a>
                        <a href="/{{$profile['username']}}/hire" class="btn btn-success btn-xs">Hire me</a>
                    </p>
                    
                </div> 
                <div class="col-md-9 hidden-xs">
                    <div class="row">
                        @if(count($profile['portfolios']) > 0)
                            @each('includes.portfolio-without-user', $profile['portfolios'], 'portfolio')
                        @endif
                    </div>
                </div>
            </div>          
        </div>
    </div>
</div>
