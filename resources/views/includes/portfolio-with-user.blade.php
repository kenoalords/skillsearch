<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">

    <div class="image-wrapper">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="img-responsive">
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
                <div class="media-heading pull-left"><a href="/{{ $portfolio['user'] }}">{{ $portfolio['user_profile']['first_name'] }}</a></div>
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
    </div>
</div>
