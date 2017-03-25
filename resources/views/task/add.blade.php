@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                <div class="panel-heading">Add New Task</div>

                <div class="panel-body">
                    <form action="{{ route('create_task') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Task title</label>
                            <input type="text" name="title" class="form-control" autofocus value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Task description</label>
                            <textarea rows="10" name="description" class="form-control">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="location" id="location">Location</label>
                            <div class="input-group {{ $errors->has('location') ? ' has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <input type="text" name="location" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{ old('location') }}">
                            </div>
                            @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="">Category</label>
                            <select name="category" class="form-control">
                                <option value="">Select</option>
                                @foreach ($skills as $skill)
                                <option value="{{$skill->skill}}">{{$skill->skill}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="input-group {{ $errors->has('budget') ? ' has-error' : '' }}">
                                <span class="input-group-addon">Budget (N)</span>
                                <input type="number" name="budget" class="form-control" placeholder="e.g 50000">
                            </div>
                            @if ($errors->has('budget'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('budget') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('budget_type') ? ' has-error' : '' }}">
                            <label for="">Budget type</label>
                            <select name="budget_type" class="form-control">
                                <option value="">Select</option>
                                <option value="fixed">Fixed</option>
                                <option value="negotiable">Negotiable</option>
                            </select>
                            @if ($errors->has('budget_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('budget_type') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="only_portfolio" value="1"> Only users with portfolios can apply
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_public" value="1"> Make this task public
                            </label>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-default">Submit Task</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection