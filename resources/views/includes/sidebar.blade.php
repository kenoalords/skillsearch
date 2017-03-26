<div class="white-boxed">
    <p class="text-center">
        <img src="{{ $profile->getAvatar() }}" alt="" width="100" class="img-circle" height="100">
    </p>
    <h4 class="text-center">{{$profile->first_name}} {{$profile->last_name}}</h4>
    <div class="text-center">
        <p><a href="{{ route('edit_profile') }}"><small class="bold">Edit profile</small></a></p>
        <p><privacy-toggle privacy="{{ $profile->is_public }}"></privacy-toggle></p>
    </div>
</div>
<hr>
<div class="list-group">
    <a href="/home" class="list-group-item"><i class="glyphicon glyphicon-home"></i> Home</a>
    <a href="{{ route('edit_profile') }}" class="list-group-item"><i class="glyphicon glyphicon-user"></i> Profile</a>
    <!-- <a href="{{ route('phone') }}" class="list-group-item"><i class="glyphicon glyphicon-phone"></i> Phone</a> -->
    <a href="{{ route('requests') }}" class="list-group-item"><i class="glyphicon glyphicon-paperclip"></i> Requests</a>
    <a href="/profile/portfolio" class="list-group-item"><i class="glyphicon glyphicon-briefcase"></i> Portfolio</a>
    <!-- <a href="#" class="list-group-item"><i class="glyphicon glyphicon-heart"></i> Likes</a> -->
    <a href="{{ route('reviews') }}" class="list-group-item"><i class="glyphicon glyphicon-star"></i> Reviews</a>
    <a href="/profile/delete" class="list-group-item"><i class="glyphicon glyphicon-user"></i> Delete Account</a>
    <a href="{{ route('logout') }}" class="list-group-item"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        <i class="glyphicon glyphicon-off"></i> Logout
    </a>
</div>