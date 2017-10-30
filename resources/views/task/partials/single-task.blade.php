<div class="">
    <h1 class="ui huge header">{{ $task['title'] }}</h1>
    <div class="ui horizontal small list">
<!--         <li><img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="img-circle" width="16" height="16"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span></li>
 -->     
        <div class="item">
            <img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="ui avatar image"> <a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a>
        </div>
        <div class="item">{{$task['date']}}</div>  
        <div class="item">in <a href="#" class="bold">{{$task['category']}}</a></div>
        <div class="item"><i class="icon marker"></i> {{$task['location']}}</div>
    </div>
    @if($task['budget'])
        <div class="item">
            <span class="ui huge red header">
                ₦{{ number_format($task['budget']) }}
                @if($task['budget_type'])
                    <div class="sub header">{{ $task['budget_type'] }}</div>
                @endif
            </span>
        </div>
    @endif
    
    <p style="margin-top: 2em">
        {!! nl2br($task['description']) !!}
    </p>
    @if($task['expires_human'])
    <h4 class="ui header">Expires {{ $task['expires_human'] }}</h4>
    @endif
    @include('includes.share.job', ['task'=>$task])
    <div class="ui small horizontal list">
        @if(Auth::user() && Auth::user()->id === $task['user_id'])
        <div class="item"><a href="{{ route('task_interest', ['task'=>$task['id']]) }}" class="ui green icon labeled button"><i class="icon user"></i>View applications</a></div>
        @else
        <div class="item">
            @if( $task['application_limit'] > 0 && $task['application_limit'] !== -1)
                @if( $task['application_left'] > 0 )
                    @if($task['closed'] === 0)
                        <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="ui icon labeled green button"><i class="icon write"></i>Apply</a>
                    @else
                        <span class="ui icon labeled green button disabled"><i class="icon lock"></i>Closed</span>
                    @endif
                @else
                    <span class="ui red text">Application Limit Reached!</span>
                @endif
            @else
                @if($task['closed'] === 0)
                    <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="ui icon labeled green button"><i class="icon write"></i>Apply</a>
                @else
                    <span class="ui icon labeled green button disabled"><i class="icon lock"></i> Closed</span>
                @endif
            @endif
        </div>
        
        <div class="right floated item">
            @if($task['closed'] === 0)
                <save-job job-id="{{$task['id']}}"></save-job>
                <flag-job job-id="{{$task['id']}}"></flag-job>
            @endif
        </div>
        @endif
    </div>

    <div class="ui divider"></div>
    <div class="">
        <div class="">
            <h3 class="ui header" style="margin-bottom: 2em;">
                {{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
            </h3>
            @if($task['applications'])
                <div class="ui divided relaxed list">
                    @foreach($task['applications'] as $application)
                        <div class="item">
                            <img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}" width="64" height="64" class="ui avatar image"> 
                            <div class="content">
                                <div class="header">
                                    <a href="{{ route('view_profile', [ 'user'=>$application['profile']['username'] ]) }}" class="">
                                    {{ $application['profile']['fullname']}} {!! identity_check($application['profile']['verified']) !!}
                                    </a>
                                </div>
                                <div class="description">
                                    @if($application['profile']['location'])
                                    <p>
                                        <small><i class="icon marker"></i> {{$application['profile']['location']}}</small>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
</div>