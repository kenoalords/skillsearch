@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            <h3>Contact Phone</h3>
            <hr>
            <p>Enter the phone numbers you want people to contact you through</p>
            
            @if ( !$phones->count() )
            <div class="panel panel-default">
               <div class="panel-body">
                   <a href="{{ route('add_phone') }}" class="btn btn-primary">Add phone number</a>
                     You have not added any phone records yet
                </div>
            </div>
            @else
                        
            @foreach ( $phones as $phone )
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4 class="pull-left">
                            <i class="glyphicon {{$phone->is_private ? 'glyphicon glyphicon-eye-open' : 'glyphicon glyphicon-eye-close text-danger'}}"></i>  
                            {{ $phone->number }}
                        </h4>
                        <div class="pull-right">
                            <a href="#" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                            <a href="#" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>
                    </div>
                </div>

            @endforeach
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{ route('add_phone') }}" class="btn btn-primary">Add another number</a>
                </div>
            </div>

            @endif
                
        </div>
    </div>
</div>
@endsection