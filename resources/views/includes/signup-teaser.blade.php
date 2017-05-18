@if(!Auth::user())
    <h3 class="thin">Want to promote your work?</h3>
    <p>Create your free account and start promoting your work.</p>
    <p><a href="/register" class="btn btn-success">Sign up now</a></p>
@endif