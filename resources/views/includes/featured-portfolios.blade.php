<div id="showcase">
    <div class="ui container">
        <h1 class="ui centered header">Featured work</h1>
        <div class="ui grid slick-js" id="portfolio-data" style="padding: 2em 0">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
        @if( !Auth::user() )
            <div class="ui centered grid" style="margin-top: 2em">
                <h4 class="ui grey header">
                    Want to showcase your works and get hired?
                    <div class="sub header" style="margin-top: 1em">
                        <a href="/register" class="ui green button">Start here <i class="icon arrow right"></i></a>   
                    </div>
                </h4>
            </div>
        @endif
    </div>
</div>