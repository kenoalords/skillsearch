<div class="col-xs-12 col-sm-4 col-md-3">

    <div class="image-wrapper">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="img-responsive b-lazy">
        </a>
        <div class="p-content clearfix">
            <h5 class="bold pull-left"><a href="{{ $portfolio['link']['url'] }}">{{ str_limit($portfolio['title'], 20) }}</a></h5>
            <span class="pull-right" style="color: #fff; line-height: 0">
                @if($portfolio['type'] == 'images')
                <i class="glyphicon glyphicon-camera"></i>
                @endif
                @if($portfolio['type'] == 'video')
                <i class="glyphicon glyphicon-facetime-video"></i>
                @endif
                @if($portfolio['type'] == 'audio')
                <i class="glyphicon glyphicon-music"></i>
                @endif
            </span>
        </div>
    </div>
    
    <div class="portfolio-credit">
        <div class="media">
            <div class="media-left">
                <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="" width="24" height="24" class="img-circle">
            </div>
            <div class="media-body">
                <div class="media-heading pull-left"><a href="/{{ $portfolio['user'] }}">{{ $portfolio['user_profile']['first_name'] }} {!! identity_check($portfolio['verified']) !!}</a></div>
                <ul class="list-inline pull-right text-muted">
                <li>
                    <small><i class="glyphicon glyphicon-heart"></i> 
                    {{$portfolio['likes_count']}} </small>
                </li>
                <li>
                     <small><i class="glyphicon glyphicon-comment"></i> 
                    {{$portfolio['comment_count']}}</small>
                </li>
                <li>
                     <small><i class="glyphicon glyphicon-eye-open"></i> 
                    {{$portfolio['views']}}</small>
                </li>
            </ul>
            </div>
        </div>
        @if(Auth::user() && ( $portfolio['user_id'] === Auth::user()->id ) )
        <strong style="display: block; margin-top: .5em; padding-top: .5em; border-top: 1px solid #eee">
            <a href="{{route('edit_portfolio', ['portfolio'=>$portfolio['uid']])}}" class="">
                <small>Edit</small>
            </a>
            <a href="{{route('delete_portfolio', ['portfolio'=>$portfolio['uid']])}}" class="">
                <small class="">Delete</small>
            </a>
        </strong>
        @endif
    </div>
    
</div>

