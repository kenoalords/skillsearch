<div class="eight wide mobile five wide tablet four wide computer column">
    <div class="ui fluid card">
        <div class="content tablet-only">
            <a href="{{ $portfolio['user'] }}" style="font-size: .875em; font-weight: 700">
                <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                 {{ $portfolio['user_profile']['first_name'] }} {!! identity_check($portfolio['verified']) !!}
            </a>
        </div>
        <div class="ui fluid image">
            <a href="{{ $portfolio['link']['url'] }}" style="line-height: 0; display: block;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class=" b-lazy">
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
                <a href="{{ $portfolio['user'] }}" class="large-screen-only">
                    <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" class="ui avatar image">
                     {{ $portfolio['user_profile']['first_name'] }} {!! identity_check($portfolio['verified']) !!}
                </a>

                <span class="right floated meta large-screen-only">
                    <span class="bold"><i class="fa fa-thumbs-up"></i> {{$portfolio['likes_count']}} </span>
                    <span class="bold" style="margin-left: 1em"><i class="fa fa-comment"></i> {{$portfolio['comment_count']}}</span>
                </span>

                <span class="meta mobile-only tablet-only">
                    <span class="bold"><i class="fa fa-thumbs-up"></i> {{$portfolio['likes_count']}} </span>
                    <span class="bold" style="margin-left: 1em"><i class="fa fa-comment"></i> {{$portfolio['comment_count']}}</span>
                </span>
            </div>
            
        </div>
        
        
    </div>
</div>