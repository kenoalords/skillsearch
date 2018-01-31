@if(Request::session()->has('status'))
    <div class="notification is-primary">
        {{Request::session()->pull('status')}}
    </div>
@endif