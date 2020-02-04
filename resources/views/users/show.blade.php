@extends('layouts.app')

@section('content')


    <div class="row justify-content-center">
        <div class="col-8 col-lg-4">

            {{ Form::model($user,['url'=>route('users.update',$user),'method'=>'PATCH']) }}
            @include('users._form') 
            {{ Form::close() }}
        </div>
    </div>

@stop
