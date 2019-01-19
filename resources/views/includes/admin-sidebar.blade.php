<div class="section is-dark">
        <aside class="menu">
            <p class="menu-label">General</p>    
            <ul class="menu-list">
                <li><a href="{{ route('dashboard') }}" class="{{ (Request::path() === 'dashboard') ? 'is-active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('portfolio_index') }}" class="{{ (Request::path() == 'dashboard/portfolio') ? 'is-active' : '' }}">Portfolio</a></li>
                <li><a href="{{ route('blog') }}" class="{{ (Request::path() == 'dashboard/blog') ? 'is-active' : '' }}">Blog</a></li>
            </ul>
            
            <p class="menu-label">Contact</p>
            <ul class="menu-list">
                <li><a href="{{ route('enquiries') }}" class="{{ (Request::path() == 'dashboard/enquiries') ? 'is-active' : '' }}">Enquiries <span class="count">{{ $enquiry_count }}</span></a></li>
            </ul>

            <p class="menu-label">Account</p>
            <ul class="menu-list">
                <li><a href="{{ route('gmail_invite') }}">Invite Friends</a></li>
                <li><a href="{{ route('edit_profile') }}" class="{{ (Request::path() == 'dashboard/profile/edit') ? 'is-active' : '' }}">Profile</a></li>
                <li><a href="{{ route('verify_identity') }}" class="{{ (Request::path() == 'dashboard/profile/verify-identity') ? 'is-active' : '' }}">Verify Identity <span class="icon verified"></span></a></li>
                <!-- <li><a href="/dashboard/profile/delete">Delete Account</a></li> -->
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
            
            @if(Auth::user()->is_admin === 1)
                <p class="menu-label">Administrator</p>
                <ul class="menu-list">
                    <li><a href="{{ route('verify_user_accounts') }}">Verify User Accounts</a></li>
                    <li><a href="{{ route('email_broadcast') }}">Send Email Broadcast</a></li>
                    <li><a href="{{ route('delete_invites') }}">Delete Invite Emails</a></li>
                </ul>
            @endif
        </aside>
</div>

