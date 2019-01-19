@if(Request::session()->has('status'))
    <div class="notification is-success">
        <span class="icon"><i class="fa fa-check-circle"></i></span> <span>{!! Request::session()->pull('status') !!}</span>
    </div>
@endif

@if(Request::session()->has('error'))
    <div class="notification is-danger">
        <span class="icon"><i class="fa fa-exclamation-triangle"></i></span> <span>{!! Request::session()->pull('error') !!}</span>
    </div>
@endif
