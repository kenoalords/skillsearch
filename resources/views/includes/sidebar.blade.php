<div class="white-boxed">
    <p class="text-center">
        <img src="{{ $profile->getAvatar() }}" alt="" width="100" class="img-circle" height="100">
    </p>
    <h4 class="text-center">{{$profile->first_name}} {{$profile->last_name}} {!! identity_check($profile->getVerified()) !!}</h4>
    <div class="text-center">
        <p><a href="{{ route('edit_profile') }}"><small class="bold">Edit profile</small></a></p>
        <p><privacy-toggle privacy="{{ $profile->is_public }}"></privacy-toggle></p>
    </div>
</div>
<hr>
<div class="list-group hidden-xs">
    <!-- <a href="/home" class="list-group-item"><i class="glyphicon glyphicon-home"></i> Home</a> -->
    <!-- <a href="{{ route('edit_profile') }}" class="list-group-item"><i class="glyphicon glyphicon-user"></i> Profile</a> -->
    <!-- <a href="{{ route('phone') }}" class="list-group-item"><i class="glyphicon glyphicon-phone"></i> Phone</a> -->
    <a href="{{ route('requests') }}" class="list-group-item"><i class="glyphicon glyphicon-apple"></i> Requests</a>
    <a href="/profile/portfolio" class="list-group-item"><i class="glyphicon glyphicon-briefcase"></i> Portfolio</a>
    <a href="/profile/portfolio/instagram" class="list-group-item"><i class="fa fa-instagram"></i> Instagram Feed</a>
    <!-- <a href="#" class="list-group-item"><i class="glyphicon glyphicon-heart"></i> Likes</a> -->
    @if(Auth::user()->is_admin === 1)
    <a href="{{ route('verify_user_accounts') }}" class="list-group-item"><i class="glyphicon glyphicon-ok-sign"></i> Verify User Accounts</a>
    <a href="{{ route('approve_jobs') }}" class="list-group-item"><i class="glyphicon glyphicon-ok-sign"></i> Job Approval</a>
    @endif
    <a href="/invite" class="list-group-item"><i class="glyphicon glyphicon-heart"></i> Invite Your Friends</a>
    <a href="/profile/delete" class="list-group-item"><i class="glyphicon glyphicon-user"></i> Delete Account</a>
    <a href="{{ route('logout') }}" class="list-group-item"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        <i class="glyphicon glyphicon-off"></i> Logout
    </a>
</div>