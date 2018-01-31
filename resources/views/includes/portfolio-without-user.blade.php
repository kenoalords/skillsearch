<div class="column">
    <div class="ui fluid card" itemscope itemtype="http://schema.org/CreativeWork">
        <div class="image">
            <a href="{{ $portfolio['link']['url'] }}" style="line-height: 0; display: block;" itemprop="url">
                <img src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="ui fluid image" >
                <meta itemprop="thumbnailUrl" content="{{ $portfolio['thumbnail'] }}">
            </a>
            @if(Auth::user() && ( $portfolio['user_id'] === Auth::user()->id ) )
            <div class="action-links">
                <a href="{{route('edit_portfolio', ['portfolio'=>$portfolio['uid']])}}" class=""><i class="icon write"></i></a>
                <a href="{{route('delete_portfolio', ['portfolio'=>$portfolio['uid']])}}" class=""><i class="icon delete"></i></a>
            </div>
            @endif
            @if($portfolio['is_featured'])
            <div class="featured-tag"><i class="icon star"></i></div>
            @endif
        </div>
        <meta itemprop="description" content="{{ str_limit($portfolio['description'], 160) }}">
        <div class="content">
            <div class="small bold">
                <!-- <div class="right floated meta">14h</div> -->
                <a href="/{{ $portfolio['user'] }}">
                    <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                    {!! identity_check($portfolio['verified']) !!}
                </a>

                <span class="right floated meta">
                    <span class="bold"><i class="fa fa-thumbs-up"></i> {{$portfolio['likes_count']}}</span>
                    <span class="bold" style="margin-left: 1em"><i class="fa fa-comment"></i> {{$portfolio['comment_count']}}</span>
                    <featured uid="{{ $portfolio['uid'] }}" stared="{{ $portfolio['is_featured'] }}"></featured>
                </span>
            </div>
            
        </div>
        
    </div>
</div>