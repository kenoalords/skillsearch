<div class="column">
    <div class="ui fluid card">
        <div class="image">
            <a href="{{ $portfolio['link']['url'] }}" style="line-height: 0; display: block;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="b-lazy">
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
                <a href="{{ $portfolio['user'] }}">
                    <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                     {{ $portfolio['user_profile']['first_name'] }} {!! identity_check($portfolio['verified']) !!}
                </a>

                <span class="right floated meta">
                    <!-- <span class="bold"><i class="icon thumbs up"></i> {{$portfolio['likes_count']}} </span> -->
                    <like-button id="{{$portfolio['uid']}}" class="bold" likes="{{$portfolio['likes_count']}}" liked="{{$portfolio['has_liked']}}"></like-button>
                    <span class="bold" style="margin-left: 1em"><i class="fa fa-comment"></i> {{$portfolio['comment_count']}}</span>
                </span>
            </div>
            
        </div>
        
    </div>
</div>