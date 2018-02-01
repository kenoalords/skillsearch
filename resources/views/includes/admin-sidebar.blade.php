<div class="hero is-grey">
    <div class="hero-body">
        <aside class="menu">
            <p class="menu-label">General</p>    
            <ul class="menu-list">
                <li><a href="/dashboard" class="{{ (Request::path() === 'dashboard') ? 'is-active' : '' }}">Dashboard</a></li>
                <li><a href="/dashboard/portfolio" class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }}">Portfolio</a></li>
                <li><a href="/dashboard/jobs" class="{{ (Request::path() == 'dashboard/jobs') ? 'is-active' : '' }}">Jobs</a></li>
            </ul>
            
            <p class="menu-label">Contact</p>
            <ul class="menu-list">
                <li><a href="{{ route('phone') }}" class="{{ (Request::path() == 'dashboard/profile/phone') ? 'is-active' : '' }}">Contact Number</a></li>
                <li><a href="{{ route('user_contact_requests') }}" class="{{ (Request::path() == 'dashboard/contact-requests') ? 'is-active' : '' }}">Contact Request <span class="tag is-primary is-small">{{$req}}</span></a></li>
                <!-- <li><a href="{{ route('referral') }}">Referrals</a></li> -->
            </ul>

            <p class="menu-label">Account</p>
            <ul class="menu-list">
                <li><a href="/invite">Invite Friends</a></li>
                <li><a href="/dashboard/profile/edit" class="{{ (Request::path() == 'dashboard/profile/edit') ? 'is-active' : '' }}">Edit Profile</a></li>
                <li><a href="/dashboard/profile/delete">Delete Account</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
            
            @if(Auth::user()->is_admin === 1)
                <p class="menu-label">Administrator</p>
                <ul class="menu-list">
                    <li><a href="{{ route('verify_user_accounts') }}">Verify User Accounts</a></li>
                    <li><a href="/dashboard/email-broadcast">Send Email Broadcast</a></li>
                    <li><a href="{{ route('delete_invites') }}">Delete Invite Emails</a></li>
                </ul>
            @endif
        </aside>
    </div>
</div>
<br>

