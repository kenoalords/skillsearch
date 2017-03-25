@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Add Phone Number</div>
    
                <div class="panel-body">

                    <form class="inline-form" role="form" method="POST" action="{{ route('add_phone') }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="input-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="input-group-addon">
                                    <strong class="glyphicon glyphicon-phone"></strong>
                                </div>                          
                                <input type="text" class="form-control" aria-label="..." name="phone" placeholder="e.g 08012345678">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div><!-- /input-group -->
                        </div>

                        <div class="form-inline">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_private" value="1"> Make this number public
                                </label>
                            </div>

                            <div class="form-group pull-right">
                                <button class="btn btn-primary" type="submit">Add Number</button>
                            </div>

                        </div>               

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection