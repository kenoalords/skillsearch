<div class="ui vertical menu">
    <div class="item center aligned">
        <h4 class="small-header">{{$profile->first_name}} {{$profile->last_name}} {!! identity_check($profile->getVerified()) !!}</h4>
        <div class="ui horizontal list">
            <span class="item"><a href="{{ route('edit_profile') }}" class="ui mini button">Edit Profile</a></span>
            <privacy-toggle privacy="{{ $profile->is_public }}" class="item"></privacy-toggle>
        </div>
    </div>
    <div class="item">
        <div class="header">Portfolio</div>
        <div class="menu">
            <a href="/profile/portfolio/add" class="item"><i class="icon plus"></i>Add Portfolio</a>
            <a href="/profile/portfolio" class="item"><i class="icon suitcase"></i>My Portfolio</a>
            <a href="/profile/portfolio/instagram" class="item"><i class="icon instagram"></i> Instagram Feed</a>
        </div>
    </div>
    <div class="item">
        <div class="header">Jobs</div>
        <div class="menu">
            <a href="{{ route('add_task') }}" class="item"><i class="icon plus"></i>Add Job</a>
            <a class="item" href="{{ route('user_jobs') }}"><i class="icon folder open outline"></i>My Jobs</a>
            <a href="{{ route('user_applications') }}" class="item"><i class="icon write square"></i>My Applications</a>
            <a href="{{ route('saved_task') }}" class="item"><i class="icon save"></i>Saved Jobs</a>
            @if(Auth::user()->is_admin === 1)
            <a href="{{ route('approve_jobs') }}" class="item"><i class="icon check square"></i>Approve Jobs</a>
            @endif
        </div>
    </div>
    <a href="{{ route('phone') }}" class="item">Phone</a>
    <a href="{{ route('user_contact_requests') }}" class="item">Contact Requests <span id="req-count" class="ui label">{{$req}}</span></a>

    <a href="{{ route('requests') }}" class="item">Messages</a>
    @if(Auth::user()->is_admin === 1)
    <a href="{{ route('verify_user_accounts') }}" class="item">Verify User Accounts</a>
    @endif
    <a href="/invite" class="item"><i class="glyphicon glyphicon-heart"></i> Invite Your Friends</a>
    <a href="/profile/delete" class="item"><i class="glyphicon glyphicon-user"></i> Delete Account</a>
    <a href="{{ route('logout') }}" class="item"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        <i class="glyphicon glyphicon-off"></i> Logout
    </a>
</div>
