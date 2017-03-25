@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center">Reset Password</h3>
            <hr>
            <div class="panel panel-default boxed">
                
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->

                            <div>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Enter your password">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
