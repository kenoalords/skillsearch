<div class="">
    <div class="clearfix"> 
        <div class="pull-left">
            <img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="img-circle" width="24" height="24"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span> <em class="text-muted">{{$task['date']}}</em>
        </div>
        <div class="pull-right">
            <a href="{{ url()->previous() }}" class="text-muted"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <hr>
    <h1 class="bold">{{ $task['title'] }}</h1>
    <ul class="list-inline" style="font-size: .875em">
<!--         <li><img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="img-circle" width="16" height="16"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span></li>
 -->        
        <li>in <a href="#" class="bold">{{$task['category']}}</a></li>
        <li class="bold"><i class="fa fa-map-marker"></i> {{$task['location']}}</li>
        <li class="bold">{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}</li>
        <li class="bold"><em>{{$task['date']}}</em></li>
        
        @if($task['budget'])
            <li class="pull-right">
                <span class="budget bold">₦{{ number_format($task['budget']) }}</span>
            </li>
        @endif
        @if($task['budget_type'])
            <li class="bold">**{{ $task['budget_type'] }}</li>
        @endif
        @if($task['expires_at'])
            <li class="bold text-warning">Expires {{ $task['expires_human'] }}</li>
        @endif
    </ul>
    <br><br>
    <p>
        {!! nl2br($task['description']) !!}
    </p>
    @if($task['expires_human'])
    <h4 class="bold text-warning">Expires {{ $task['expires_human'] }}</h4>
    @endif
    <br>
    @include('includes.share.job', ['task'=>$task])
    <ul class="list-inline clearfix">
        @if(Auth::user() && Auth::user()->id === $task['user_id'])
        <li><a href="{{ route('task_interest', ['task'=>$task['id']]) }}" class="btn btn-success btn-xs"><i class="fa fa-user"></i> View Applications</a></li>
        @else
        <li>
            @if( $task['application_limit'] > 0 && $task['application_limit'] !== -1)
                @if( $task['application_left'] > 0 )
                    @if($task['closed'] === 0)
                        <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="btn btn-success btn-xs">Submit Application</a>
                    @else
                        <span class="label label-success"><i class="fa fa-lock"></i> Closed</span>
                    @endif
                @else
                    <span class="text-warning bold">Application Limit Reached!</span>
                @endif
            @else
                @if($task['closed'] === 0)
                    <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="btn btn-success btn-xs">Submit Application</a>
                @else
                    <span class="label label-success"><i class="fa fa-lock"></i> Closed</span>
                @endif
            @endif
        </li>
        
        <li class="pull-right">
            @if($task['closed'] === 0)
                <save-job job-id="{{$task['id']}}"></save-job>
                <flag-job job-id="{{$task['id']}}"></flag-job>
            @endif
        </li>
        @endif
    </ul>

    <hr>
    <div class="">
        <div class="">
            <h4 class="bold" style="margin-bottom: 2em;">
                {{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
            </h4>
            @if($task['applications'])
                <div id="applications">
                    @foreach($task['applications'] as $application)
                        <div class="media">
                            <div class="media-left">
                                <a href="{{ route('view_profile', [ 'user'=>$application['profile']['username'] ]) }}">
                                    <img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}" width="64" height="64" class="img-circle media-object"> 
                                    
                                </a>
                            </div>

                            <div class="media-body">
                                <div class="media-heading">
                                    <a href="{{ route('view_profile', [ 'user'=>$application['profile']['username'] ]) }}" class="">
                                    <span class="bold">{{ $application['profile']['fullname']}} {!! identity_check($application['profile']['verified']) !!}
                                            <small class="text-muted"><em>{{ $application['date'] }}</em></small>
                                        </span>
                                    </a>
                                    <span class="budget bold pull-right" style="font-size: 1.2em">
                                        ₦{{ number_format($application['budget']) }}
                                    </span>
                                    @if($application['profile']['location'])
                                    <p>
                                        <small><i class="fa fa-map-marker"></i> {{$application['profile']['location']}}</small>
                                    </p>
                                    @endif
                                </div>
                                @if(count($application['profile']['skills']) > 0)
                                <div class="skills">
                                    @foreach ($application['profile']['skills'] as $skill)
                                        <a href="/search/?term={{ $skill['skill'] }}" class="label label-default">{{ $skill['skill'] }}</a>
                                    @endforeach
                                </div>
                                @endif
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
</div>