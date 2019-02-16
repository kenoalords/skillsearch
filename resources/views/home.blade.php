@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    @if( Request::get('step') && Request::get('step') === "1" )
        <div>
            <div class="spaced-title">Step {{ Request::get('step') }}</div>
            <div class="has-text-centered box" style="margin-bottom: 10px">
                <h2 class="title is-2 is-size-4-mobile bold" style="margin-bottom: 5px;">Upload profile picture</h2>
                <p>Click on the image</p>
                <upload-image img-src="{{ auth()->user()->profile->getAvatar() }}"></upload-image>
            </div>
             <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <a href="/dashboard?step=2">
                            Skip
                        </a>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="/dashboard?step=2" class="button is-info">
                            <span>Proceed</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif( Request::get('step') && Request::get('step') === "2" )
        <div>
            <div class="spaced-title">Step {{ Request::get('step') }}</div>
            <h2 class="title is-2 is-size-4-mobile bold">Select your skills</h2>
            <skills :intro="true"></skills>
        </div>

    @elseif( Request::get('step') && Request::get('step') === "3" )
        <div>
            <div class="spaced-title">Step {{ Request::get('step') }}</div>
            <h2 class="title is-2 is-size-4-mobile bold">Tell us a little bit about yourself.</h2>
            <div class="box">
                <biography></biography>
            </div>
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="/dashboard?step=4">
                            Skip
                        </a>
                    </div>
                </div>
        </div>

    @elseif( Request::get('step') && Request::get('step') === "4" )
        <!-- Find people to follow -->
        <div class="spaced-title">Step {{ Request::get('step') }}</div>
        <h1 class="title is-2 is-size-4-mobile bold" style="margin-bottom: 10px;">Follow at least 5 creative people related to your interests.</h1>
        <p style="margin-bottom: 2em;">😎 Ubanji is so cool when you follow other creative people.</p>
        <div class="columns is-multiline is-mobile">
            @for( $i = 0; $i < count($suggestions); $i++ )
                <div class="user-to-follow step has-text-centered column is-half-mobile is-one-quarter-desktop is-one-third-tablet">
                    <div>
                        <figure class="image is-rounded is-64x64 is-centered">
                            <img src="{{ avatar($suggestions[$i]->id) }}" alt="{{ ucfirst($suggestions[$i]->first_name) }}">
                        </figure>
                        <h4 class="title is-6" style="margin-bottom: 0.7em"><a href="{{ route('view_profile', ['user'=>$suggestions[$i]->name]) }}">{{ ucfirst($suggestions[$i]->first_name) }}</a></h4>
                        <!-- Skills -->
                        <span class="skills">
                            {!! getSkills($suggestions[$i]->id) !!}
                        </span>
                        
                    </div>
                    <form action="/follower/{{$suggestions[$i]->name}}" method="post" class="follow-user-form">
                        <button type="submit" class="button is-small is-info is-fullwidth">Follow</button>
                    </form>
                </div>
            @endfor
        </div>
        <div class="has-text-right">
            <a href="{{ route('dashboard', ['step'=>5]) }}" class="button is-info">
                <span>Proceed</span> <span class="icon"><i class="fa fa-arrow-right"></i></span>
            </a>
        </div>
    @elseif( Request::get('step') && Request::get('step') === "5" )
    
        <div class="spaced-title">Step {{ Request::get('step') }}</div>
        <h1 class="title is-2 is-size-3-mobile bold" style="margin-bottom: 10px;">Upload your best works.</h1>
        <p style="margin-bottom: 2em;">It's the fastest way to get new clients on ubanji. Try it now.</p>
        <div class="columns">
            <div class="column is-hidden-desktop">
                <div class="card">
                    <figure class="image">
                        <a href="{{ route('new_portfolio', ['utm_source'=>'sign_up_steps']) }}"><img src="{{ asset('images/teaser.jpg') }}" alt="Teaser"></a>
                        <figcaption class="help" style="padding: 5px;">Photo by Mwabonje from Pexels</figcaption>
                    </figure>
                </div>
            </div>
            <div class="column">
                <a href="{{ route('new_portfolio', ['utm_source'=>'sign_up_steps']) }}" class="button is-info is-fullwidth-mobile">Upload your work now</a>
            </div>
        </div>
        <p class="">
            <a href="{{ route('dashboard') }}" class="has-text-grey">Maybe later</a>
        </p>
    @else

        @include('includes.dashboard-menu')
        <!-- <h2 class="title is-2 is-size-5-mobile bold">Hello {{ $user['first_name'] }}!</h2> -->
        <div class="modal push-notification-modal">
            <div class="modal-background"></div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-content has-text-centered">
                        <h1 class="title is-1">🔔</h1>
                        <h3 class="title is-4 bold">
                            Don't miss important activities and updates on your page.
                        </h3>
                        <p>
                            <a href="#" class="push-notification button is-fullwidth-mobile is-danger big-action-button"><span class="icon"><i class="fa fa-bell"></i></span> <span>Enable notification</span> </a>
                        </p>
                        <p>
                            <a href="#" class="close-push-notification-modal has-text-grey">I'll do this later</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        @include('includes.status')
        
        <!-- Portfolio section -->
        @if ( $portfolios )
            <div style="padding: 4em 0">
                <h2 class="title is-3 is-size-4-mobile has-text-black bold" style="margin-bottom: 10px;">Be inspired.</h2>
                <p>
                    View recent works from the community. Like, Comment and Share.
                </p>
                <p style="margin-bottom: 3em;">
                    <a href="{{ route('new_portfolio') }}" class="has-text-weight-bold button is-info is-raised">
                        <span class="icon"><i class="fa fa-upload"></i></span> <span>Upload Work</span>
                    </a>
                </p>
                <div class="columns is-multiline is-mobile">
                    @each('includes.portfolio-with-user',  $portfolios, 'portfolio')
                </div>
            </div>
        @else
        @endif



        @if ( empty($user['skills']) )
            <div class="notification is-raised is-bordered-left is-padded is-white">
                <h3 class="title is-3 is-size-5-mobile bold">
                    Setup your skills to see what other people like you are sharing
                </h3>
                <p>
                    Get inspired by other peoples work and find people to follow.
                </p>
                <p><a href="{{ route('edit_profile') }}" class="button is-info big-action-button is-fullwidth-mobile">Add your skills</a></p>
            </div>
        @endif
        
        @if($suggestions)
        <div class="follow-suggestion is-white">
            <h2 class="title is-3 is-size-4-mobile has-text-black is-marginless bold">Who to follow</h2>
            <p>Make it more interesting by following others</p>
            <div class="user-to-follow-wrapper ">
                <div class="">
                    <div class="scrollable-x columns is-mobile">
                        @for( $i = 0; $i < count($suggestions); $i++ )
                            <div class="user-to-follow has-text-centered column is-half-mobile is-one-quarter-desktop is-one-third-tablet">
                                <div class="user">
                                    <figure class="image is-rounded is-64x64 is-centered">
                                        <img src="{{ avatar($suggestions[$i]->id) }}" alt="{{ ucfirst($suggestions[$i]->first_name) }}">
                                    </figure>
                                    <h4 class="title is-6" style="margin-bottom: 0.7em"><a href="{{ route('view_profile', ['user'=>$suggestions[$i]->name]) }}">{{ ucfirst($suggestions[$i]->first_name) }}</a></h4>
                                    <span class="skills">
                                        {!! getSkills($suggestions[$i]->id) !!}
                                    </span>
                                    
                                </div>
                                <form action="/follower/{{$suggestions[$i]->name}}" method="post" class="follow-user-form">
                                    <button type="submit" class="button is-small is-info is-fullwidth">Follow</button>
                                </form>
                            </div>
                            
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Blog section -->
        @if ( $blogs )
            <div style="padding: 4em 0">
                <h2 class="title is-3 is-size-4-mobile has-text-black bold" style="margin-bottom: 10px;">Find and read articles that inspire you to grow.</h2>
                <p>♥️ Connect with authors you love.</p>
                <p style="margin-bottom: 3em">
                    <a href="{{ route('add_blog') }}" class="has-text-weight-bold button is-info is-raised">
                        <span class="icon"><i class="fa fa-pencil"></i></span> <span>Write new</span>
                    </a>
                </p>         
                
                <div class="columns is-multiline is-mobile">
                    @each('blog.partials.blog',  $blogs, 'blog')
                </div>
                <p>
                    <a href="{{ route('add_blog') }}" class="button is-info big-action-button">Write something interesting</a>
                </p>
            </div>
        @else
        @endif

        @if($user['verified_email'] === 0)
            <div class="notification is-white is-raised is-bordered-left">
                <div class="is-size-6"><span class="icon"><i class="fa fa-envelope"></i></span> Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
            </div>
        @endif

        @if($gmail === true && $invite_status === false)
            @include('includes.gmail-invite')
        @endif

        @if(!$user['verified'])
            <div class="notification is-white is-raised is-bordered-left">
                <div class="is-size-6"><span class="icon verified"></span> Verify your identity and increase your ranking instantly and improve your credibility score <a href="{{ route('verify_identity') }}">Verify my identity</a></div>
            </div>
        @endif

        @if(Auth::user()->is_admin === 1)
        <div class="hero is-dark">
            <div class="hero-body has-text-centered">
                <h3 class="title is-4 is-size-6-mobile">Send contact invite reminder</h3>
                <send-reminder></send-reminder>
            </div>
        </div>
        @endif

    @endif
    
    
    
@endsection
