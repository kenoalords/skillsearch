@if(!Auth::user())
<div id="how" class="hero is-dark">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-8 has-text-centered">
                <h2 class="title is-3">
                    Showcase your creative works
                </h2>
                <p class="subtitle">and attract the best clients</p>
                <p><a href="/register" class="button is-danger"><span>Get started now</span> <span class="icon"><i class="fa fa-arrow-right"></i></span></a></p>
                <p class="is-small">Find out <a href="/how-it-works">how it works</a></p>
            </div>
        </div>
    </div>
</div>
@endif