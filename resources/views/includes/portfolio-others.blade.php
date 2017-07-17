<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="image-wrapper whiteCard">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="b-lazy img-responsive">

        </a>
        <div class="p-content clearfix">
            <!-- <h5 class="bold"><a href="{{ $portfolio['link']['url'] }}">{{ str_limit($portfolio['title'], 20) }}</a></h5> -->
            <span class="pull-left" style="position: relative; top: 3px;">
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

            <ul class="list-inline clearfix pull-right">
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

    <div class="portfolio-credit">
        <div class="media">
            <div class="media-left">
                <img src="{{ $portfolio['user_profile']['avatar'] }}" alt="{{ $portfolio['user_profile']['fullname'] }}" width="24" height="24" class="img-circle ">
            </div>
            <div class="media-body">
                <div class="media-heading pull-left"><a href="/{{ $portfolio['user'] }}">{{ $portfolio['user_profile']['first_name'] }} {!! identity_check($portfolio['verified']) !!}</a></div>
                
            </div>
        </div>
    </div>
</div>
