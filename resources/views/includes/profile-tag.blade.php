<div class="col-xs-12 col-sm-6 col-md-3 col-lg-15 white-boxed" style="padding: 2em">
    <div class="text-center">
        <p>
            <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                <img src="{{ $profile['avatar'] }}" alt="{{$profile['fullname']}}" class="img-circle" width="100" height="100">
            </a>
        </p>
        <h4 class="bold" style="margin-bottom: 1em">
            <a href="{{ route('view_profile', ['user'=>$profile['username']]) }}">
                {{$profile['fullname']}}
            </a>
            
        </h4>
        <p class="skills-default">
        @foreach ($profile['skills'] as $key => $skill)
            <a href="/search?term={{ urlencode($skill['skill']) }}" class="label label-xs label-default">{{ $skill['skill'] }}</a>
        @endforeach
        </p>
        @if($profile['location'] != '')
            <p class="bold"><small><i class="fa fa-map-marker"></i> {{$profile['location']}}</small></p>
        @endif
        
        <div>
            <follow username="{{$profile['username']}}"></follow>
        </div>
    </div>
</div>


