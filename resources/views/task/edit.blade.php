@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                <div class="panel-heading">Add New Task</div>

                <div class="panel-body">
                    <form action="{{ route('update_task', ['task'=>$task->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Task title</label>
                            <input type="text" name="title" class="form-control" autofocus value="{{ old('title') ? old('title') : $task->title }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Task description</label>
                            <textarea rows="10" name="description" class="form-control">{{ old('description') ? old('description') : $task->description }}</textarea>
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
                                <input type="text" name="location" class="form-control" placeholder="e.g Ikeja, Lagos" value="{{ old('location') ? old('location') : $task->location }}">
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
                                <option value="{{$skill->skill}}" {{ old('category') == $skill->skill ? 'selected' : '' }} {{ ($task->category == $skill->skill && !old('category')) ? 'selected' : '' }}>{{$skill->skill}}</option>
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
                                <input type="number" name="budget" class="form-control" placeholder="e.g 50000" value="{{ old('budget') ? old('budget') : $task->budget }}">
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
                                <option value="fixed" {{ old('budget_type') == 'fixed' ? 'selected' : '' }} {{ ($task->budget_type == 'fixed' && !old('budget_type')) ? 'selected' : '' }}>Fixed</option>
                                <option value="negotiable" {{ old('budget_type') == 'negotiable' ? 'selected' : '' }} {{ ($task->budget_type == 'negotiable' && !old('budget_type')) ? 'selected' : '' }}>Negotiable</option>
                            </select>
                            @if ($errors->has('budget_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('budget_type') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="only_portfolio" value="1" {{ old('only_portfolio') == 1 ? 'checked' : '' }} {{ $task->only_portfolio == 1 ? 'checked' : '' }}> Only users with portfolios can apply
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_public" value="1" {{ old('is_public') == 1 ? 'checked' : '' }} {{ ($task->is_public == 1 && !old('is_public')) ? 'checked' : '' }}> Make this task public
                            </label>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-default">Save Changes</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection