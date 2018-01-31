<div class="hero is-dark is-medium">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-8">
                <h1 class="title is-2">{{ $task['title'] }}</h1>
                <div class="level is-mobile">
                    <div class="level-left">
                        <div class="level-item">
                            <img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="image is-rounded is-24x24"> <a href="{{ config('app.url') . '/' . $task['profile']['username'] }}" class="{{ ($task['profile']['verified']) ? 'verified' : '' }}">{{ $task['profile']['fullname'] }}</a>
                        </div>
                        <div class="level-item">{{$task['date']}}</div>  
                        <div class="level-item">in {{$task['category']}}</div>
                        <div class="level-item"><span class="icon"><i class="fa fa-map-marker"></i></span> <span>{{$task['location']}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-8">
                <h4 class="title is-5">Job description</h4>
                <p>{!! nl2br($task['description']) !!}</p>
                @if($task['budget'])
                    <div>
                        <h3 class="title is-5" style="margin-bottom: 0">Budget</h3>
                        <h4 class="title has-text-success is-1">
                            ₦{{ number_format($task['budget']) }}
                        </h4>
                        @if($task['budget_type'])
                            <div class="subtitle is-6">{{ $task['budget_type'] }}</div>
                        @endif
                    </div>
                @endif

                <!-- Action links -->
                <div class="level is-mobile" style="margin-top: 4em;">
                    <div class="level-left">
                        @if(Auth::user() && Auth::user()->id === $task['user_id'])
                        <div class="level-item"><a href="{{ route('task_interest', ['task'=>$task['id']]) }}" class="tag is-success"><span class="icon"><i class="icon user"></i></span> <span>View applications</span></a></div>
                        @else
                        <div class="level-item">
                            @if( $task['application_limit'] > 0 && $task['application_limit'] !== -1)
                                @if( $task['application_left'] > 0 )
                                    @if($task['closed'] === 0)
                                        <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="button is-primary"><span>Apply for this job</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a>
                                    @else
                                        <span class="tag is-danger"><span class="icon"><i class="icon lock"></i></span> <span>Closed</span></span>
                                    @endif
                                @else
                                    <span class="tag is-danger"><span class="icon"><i class="icon lock"></i></span> <span>Application limit reached</span></span>
                                @endif
                            @else
                                @if($task['closed'] === 0)
                                    <a href="{{ route('apply', ['task'=>$task['id'], 'slug'=>$task['slug']] ) }}" class="tag is-primary is-medium"><span class="icon"><i class="icon write"></i></span> <span>Apply</span></a>
                                @else
                                    <span class="tag is-danger"><span class="icon"><i class="icon lock"></i></span> <span>Closed</span></span>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <div class="right floated item">
                        @if($task['closed'] === 0)
                            <save-job job-id="{{$task['id']}}"></save-job>
                            <flag-job job-id="{{$task['id']}}"></flag-job>
                        @endif
                    </div>
                    @endif
                </div>
                @if($task['profile']['verified'] === false)
                @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
                @endif
                <hr>
                <!-- Applications -->
                <h3 class="title is-3">
                    {{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}
                </h3>
                @if($task['applications'])
                    <div>
                        @foreach($task['applications'] as $application)
                            <div class="level is-mobile">
                                <div class="level-left">
                                    <a href="{{ route('view_profile', [ 'user'=>$application['profile']['username'] ]) }}" class="{{ ($application['profile']['verified']) ? 'verified' : ''}}">
                                        <img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}" class="is-rounded is-48x48 image is-inline">
                                        <span class="has-text-grey" style="position: relative; top: 10px">{{ $application['profile']['fullname']}}</span>
                                    </a>
                                </div>
                                 
                                <div class="level-right">
                                    <a href="{{ route('view_profile', [ 'user'=>$application['profile']['username'] ]) }}" class="button is-primary is-small">
                                        <span>View profile</span>
                                        <span class="icon"><i class="fa fa-long-arrow-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


            </div>
        </div>
    </div>
</div>
