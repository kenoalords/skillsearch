<div class="col-xs-6 col-sm-6 col-md-3">

    <div class="image-wrapper">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="img-responsive b-lazy">
        </a>
        <div class="p-content clearfix">
            <div class="clearfix">
                <strong class="pull-left">
                    <a href="{{ $portfolio['link']['url'] }}">{{ str_limit($portfolio['title'], 20) }}</a>
                </strong>
                <ul class="list-inline pull-right">
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
            @if(Auth::user() && ( $portfolio['user_id'] === Auth::user()->id ) )
            <strong style="display: block; padding-top: .1em; border-top: 1px solid #eee">
                <a href="{{route('edit_portfolio', ['portfolio'=>$portfolio['uid']])}}" class="text-muted">
                    <small>Edit</small>
                </a>
                <a href="{{route('delete_portfolio', ['portfolio'=>$portfolio['uid']])}}" class="text-muted">
                    <small class="">Delete</small>
                </a>
            </strong>
            @endif
        </div>
        
    </div>
    
</div>

