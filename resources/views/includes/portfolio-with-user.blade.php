<div class="eight wide mobile five wide tablet four wide computer column" >
    <div class="ui fluid card" itemscope itemtype="http://schema.org/CreativeWork">
        <div class="content tablet-only">
            <a href="{{ $portfolio['user'] }}" style="font-size: .875em; font-weight: 700" itemprop="url">
                <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                 <span itemprop="author">{{ $portfolio['user_profile']['first_name'] }}</span> {!! identity_check($portfolio['verified']) !!}
            </a>
        </div>
        <meta itemprop="description" content="{{ str_limit($portfolio['description'], 160) }}">
        <div class="ui fluid image">
            <a href="{{ $portfolio['link']['url'] }}" style="line-height: 0; display: block;" itemprop="url">
                <img src="{{ $portfolio['thumbnail'] }}" data-src="" alt="{{$portfolio['title']}}" class="">
                <meta itemprop="thumbnailUrl" content="{{ $portfolio['thumbnail'] }}">
            </a>
            @if(Auth::user() && ( $portfolio['user_id'] === Auth::user()->id ) )
            <div class="action-links">
                <a href="{{route('edit_portfolio', ['portfolio'=>$portfolio['uid']])}}" class=""><i class="icon write"></i></a>
                <a href="{{route('delete_portfolio', ['portfolio'=>$portfolio['uid']])}}" class=""><i class="icon delete"></i></a>
            </div>
            @endif
        </div>
        <div class="content">
            <div class="small bold">
                <!-- <div class="right floated meta">14h</div> -->
                <a href="{{ $portfolio['user'] }}" class="large-screen-only" itemprop="url">
                    <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                     <span itemprop="author">{{ $portfolio['user_profile']['first_name'] }}</span> {!! identity_check($portfolio['verified']) !!}
                </a>

                <span class="right floated meta large-screen-only portfolio-meta">
                    <span class="bold"><a href="{{ $portfolio['link']['url'] }}"><i class="fa fa-thumbs-up"></i> {{$portfolio['likes_count']}}</a></span>

                    <span class="bold" style="margin-left: 1em"><a href="{{ $portfolio['link']['url'] }}#comments"><i class="fa fa-comment"></i> <span itemprop="commentCount">{{$portfolio['comment_count']}}</span></a></span>
                </span>

                <span class="meta mobile-only tablet-only portfolio-meta">
                    <span class="bold"><a href="{{ $portfolio['link']['url'] }}"><i class="fa fa-thumbs-up"></i> {{$portfolio['likes_count']}}</a></span>
                    
                    <span class="bold" style="margin-left: 1em"><a href="{{ $portfolio['link']['url'] }}#comments"><i class="fa fa-comment"></i> <span itemprop="commentCount">{{$portfolio['comment_count']}}</span></a></span>
                </span>
            </div>
            
        </div>
        
        
    </div>
</div>