@if( !Auth::user() )
    <div class="section is-teaser is-medium" style="background: url({{ asset('images/hero-back.jpg') }}) no-repeat center; background-size: cover">
        <div class="container has-text-centered">
            <div class="columns is-centered">
                <div class="column is-8">
                    <h3 class="title is-3 is-size-4-mobile bold">
                       <img src="{{ asset('images/waving-hand.png') }}" alt="" class="waving-hand"> Hello stranger!
                    </h3>
                    <p>
                        We are building the biggest community of creative and skilled people in Nigeria. Join us today to showcase your work and find new opportunities.
                    </p>
                    <!-- <p class="has-link">Spread the word by sharing on <a href="">Facebook</a>, <a href="">Twitter</a> and <a href="">Linkedin</a></p> -->
                    <p>
                        <a href="/register" class="button is-primary big-action-button"><span>Sign up now</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a>   
                    </p>
                </div>
            </div>         
        </div>             
    </div>
@else
<div class="section is-teaser is-medium" style="background: url({{ asset('images/hero-back.jpg') }}) no-repeat center; background-size: cover">
    <div class="container has-text-centered">
        <div class="columns is-centered">
            <div class="column is-8">
                <h3 class="title is-3 is-size-4-mobile bold">
                   <img src="{{ asset('images/waving-hand.png') }}" alt="" class="waving-hand"> Hello {{ Auth::user()->profile->first_name }}
                </h3>
                <p class="has-link">We need your help to build this community. It only takes 3minutes. Please help us spread the word by sharing on <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}">Facebook</a> and <a target="_blank" href="https://twitter.com/intent/tweet?url={{ Request::url() }}&via=ubanjicreatives&text=Share+your+creative+work+and+find+more+opportunities.+Join+www.ubani.com+today.&hashtags=ubanjicreatives">Twitter</a> or</p>
                <p>
                    <a href="/invite/gmail" class="button is-google is-raised" id="google-invite">
                        <span class="icon"><i class="fa fa-google"></i></span> 
                        <span>Invite your Gmail Contacts</span>
                    </a>
                </p>
                
            </div>
        </div>         
    </div>             
</div>
@endif