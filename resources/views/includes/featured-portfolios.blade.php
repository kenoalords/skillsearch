<div id="showcase">
    <div class="container">
        <h1 class="title is-3 has-text-centered">Featured work</h1>
        <div class="columns is-centered">
            <div class="column is-10">
                <div class="slick-js" style="padding: 2em 0">
                    @each('includes.portfolio-with-user', $portfolios, 'portfolio')
                </div>
            </div>
        </div>
        
        @if( !Auth::user() )
            <div class="hero">
                <div class="hero-body has-text-centered">
                    <h4 class="title is-4">
                        Want to showcase your works and get hired?
                    </h4>
                    <p>
                        <a href="/register" class="button is-primary"><span>Start here</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a>   
                    </p>
                </div>             
            </div>
        @endif
    </div>
</div>