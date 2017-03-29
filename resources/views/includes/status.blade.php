@if(Request::session()->has('status'))
    <div class="alert alert-success">
        <i class="glyphicon glyphicon-ok-sign"></i>
        {{Request::session()->pull('status')}}
    </div>
@endif