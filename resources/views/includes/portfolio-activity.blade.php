<div class="row">
    @if($portfolio['type'] == 'images')
    <div class="col-sm-3">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="img-responsive">
        </a>
    </div>
    @endif
    @if($portfolio['type'] == 'audio')
    <div class="col-sm-3">
        <a href="{{ $portfolio['link']['url'] }}">
            <img src="{{ $portfolio['thumbnail'] }}" alt="{{$portfolio['title']}}" class="img-responsive">
        </a>
    </div>
    @endif
    <div class="col-sm-9">
        <h5 class="bold"><a href="{{ $portfolio['link']['url'] }}">{{ str_limit($portfolio['title'], 20) }}</a></h5>
        <div class="clearfix">
            <ul class="list-inline pull-left text-muted">
                <li class="bold">
                    <small><i class="glyphicon glyphicon-heart"></i> 
                    {{$portfolio['likes_count']}}</small>
                </li>
                <li class="bold">
                    <small><i class="glyphicon glyphicon-comment"></i> 
                    {{$portfolio['comment_count']}}</small>
                </li>
                <li class="bold">
                    <small><i class="glyphicon glyphicon-eye-open"></i> 
                    {{$portfolio['views']}}</small>
                </li>
            </ul>
        </div>
        @if(Auth::user() && ( $portfolio['user_id'] === Auth::user()->id ) )
        <strong>
            <a href="{{route('edit_portfolio', ['portfolio'=>$portfolio['uid']])}}" class="">
                <small>Edit</small>
            </a>
            <a href="#" class="">
                <small class="">Delete</small>
            </a>
        </strong>
        @endif
    </div>
</div>
