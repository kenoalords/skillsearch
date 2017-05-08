<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
    <div class="white-boxed text-center" style="padding: 2em">
        <p>
            <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                <img src="{{ $profile['avatar'] }}" alt="{{$profile['fullname']}}" class="img-circle" width="100" height="100">
            </a>
        </p>
        <h5 class="bold" style="margin-bottom: 1em; margin-top: 2em">
            <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                {{$profile['fullname']}}
            </a>
            
        </h5>
        <p class="skills-default">
        @if(count($profile['skills']) > 0)
            <a href="/search?term={{ urlencode($profile['skills'][0]['skill']) }}" class="label label-default label-sm">{{ $profile['skills'][0]['skill'] }}</a>
            @if(count($profile['skills']) > 1)
                <small class="bold text-muted">+{{ count($profile['skills']) - 1 }} more</small>
            @endif
        @endif
        </p>
        @if($profile['location'] != '')
            <p class="bold"><small><i class="fa fa-map-marker"></i> {{$profile['location']}}</small></p>
        @endif
        
        <div>
            <follow username="{{$profile['username']}}"></follow>
        </div>
    </div>
</div>


