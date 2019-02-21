@if($portfolio)
<div class="column is-one-quarter-desktop portfolio is-half-mobile is-one-third-tablet">
    <div class="card portfolio" itemscope itemtype="http://schema.org/CreativeWork">
        <div class="card-image">
            <figure class="image is-1x1">
                <a href="{{ $portfolio['link']['url'] }}" itemprop="url" class="portfolio-popup" data-id="{{ $portfolio['id'] }}" data-uid="{{ $portfolio['uid'] }}" data-description="{{ $portfolio['description'] }}" data-thumbnail="{{ $portfolio['thumbnail'] }}" data-title="{{ $portfolio['title'] }}" data-user="{{ $portfolio['user'] }}" data-fullname="{{ $portfolio['user_profile']['fullname'] }}" data-avatar="{{ $portfolio['user_profile']['avatar'] }}" data-verified="{{ $portfolio['verified'] }}" data-likes="{{ $portfolio['likes_count'] }}">
                    <img src="{{ $portfolio['thumbnail'] }}" data-src="" alt="{{$portfolio['title']}}" class="">
                    <meta itemprop="thumbnailUrl" content="{{ $portfolio['thumbnail'] }}">
                </a>
            </figure>
            @if ( (Auth::user() && Auth::user()->id === $portfolio['user_id'] && Request::path() === 'dashboard/portfolio') || (Auth::user() && Auth::user()->is_admin === true) )
                <div class="user-links">
                    <div class="dropdown is-right">
                        <div class="dropdown-trigger">
                            <a href="#"><i class="fa fa-ellipsis-v"></i></a>
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu" role="menu">
                            <div class="dropdown-content">
                                <a href="{{ route('edit_portfolio', [ 'portfolio'=> $portfolio['uid'] ]) }}" class="dropdown-item"><span class="icon"><i class="fa fa-pencil"></i></span> <span>Edit</span></a>
                                <a href="#" class="dropdown-item delete-portfolio"><span class="icon"><i class="fa fa-eye-slash"></i></span> <span>Hide</span></a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item delete-portfolio" data-uid="{{ $portfolio['uid'] }}"><span class="icon"><i class="fa fa-trash"></i></span> <span>Delete</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($portfolio['is_featured'])
            <span class="is-featured"><img src="{{ asset('images/featured-badge.png') }}" alt="featured item"></span>
            @endif
        </div>
        <div class="card-content" style="padding: 5px;">
            <div class="level is-mobile">
                <!-- <div class="right floated meta">14h</div> -->
                <div class="level-left">
                    <a href="/{{ $portfolio['user'] }}" itemprop="url" class="has-text-weight-bold">
                        <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="image is-24x24 is-rounded is-inline">
                         <span itemprop="author" class="{{ ($portfolio['verified']) ? 'verified' : '' }} author" >{{-- $portfolio['user_profile']['first_name'] --}}</span>
                    </a>
                </div>

                <div class="level-right has-text-right">
                    <span class="level-item">
                        <span class="icon"><i class="fa fa-thumbs-up"></i></span> <span>{{$portfolio['likes_count']}}</span>
                    </span>
                    <span class="level-item">
                        <span class="icon"><i class="fa fa-comment"></i></span> <span>{{$portfolio['comment_count']}}</span>
                    </span>
                    <featured uid="{{ $portfolio['uid'] }}" :status="{{ $portfolio['is_featured'] }}"></featured>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endif