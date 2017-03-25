<div class="clearfix">
    <a href="{{ route('view_profile', ['user'=>$user->name]) }}" class="pull-left">
        <img src="{{ $profile->getAvatar() }}" class="img-circle" width="36" height="36">
    </a>
    <h5 class="pull-left bold" style="margin-left: 1em">
        <a href="{{ route('view_profile', ['user'=>$user->name]) }}">
            {{$profile->first_name}} {{$profile->last_name}}
        </a>
    </h5>
    
    <div class="pull-right">
        <follow username="{{$user->name}}"></follow>
    </div>
</div>


