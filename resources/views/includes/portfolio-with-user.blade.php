@if($portfolio)
<div class="column is-one-third-desktop is-one-quarter-widescreen is-half-tablet">
    <div class="card portfolio" itemscope itemtype="http://schema.org/CreativeWork">
        <meta itemprop="description" content="{{ str_limit($portfolio['description'], 160) }}">
        <div class="card-image">
            <figure class="image is-1x1">
                <a href="{{ $portfolio['link']['url'] }}" itemprop="url">
                    <img src="{{ $portfolio['thumbnail'] }}" data-src="" alt="{{$portfolio['title']}}" class="">
                    <meta itemprop="thumbnailUrl" content="{{ $portfolio['thumbnail'] }}">
                </a>
            </figure>
            @if($portfolio['is_featured'])
                <!-- <div class="featured-tag"><i class="icon star"></i></div> -->
            @endif
        </div>
        <div class="card-content" style="padding: 5px;">
            <div class="level is-mobile">
                <!-- <div class="right floated meta">14h</div> -->
                <div class="level-left">
                    <a href="/{{ $portfolio['user'] }}" itemprop="url" class="has-text-weight-bold">
                        <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="image is-24x24 is-rounded is-inline">
                         <span itemprop="author" class="{{ ($portfolio['verified']) ? 'verified' : '' }} author" >{{ $portfolio['user_profile']['first_name'] }}</span>
                    </a>
                </div>

                <div class="level-right has-text-right">
                    <span class="level-item">
                        <span class="icon"><i class="fa fa-thumbs-up"></i></span> <span>{{$portfolio['likes_count']}}</span>
                    </span>
                    <span class="level-item">
                        <span class="icon"><i class="fa fa-comment"></i></span> <span>{{$portfolio['comment_count']}}</span>
                    </span>
                    <featured uid="{{ $portfolio['uid'] }}"></featured>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endif