@if(Request::session()->has('status'))
    <div class="ui info message">
        {{Request::session()->pull('status')}}
    </div>
@endif