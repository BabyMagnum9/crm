@extends('layouts.app')

@section('content')

    {{ Form::model($user,['url'=>route('users.update',$user),'method'=>'PATCH']) }}

    <div class="row justify-content-center">
        <div class="col-8 col-lg-4">
            @include('users._form')
        </div>

        <div class="col-lg-4">
            @include('users.show._phones')
        </div>
        <div class="col-lg-4">
            @include('users.show._emails')
        </div>
        <div class="col-lg-4">
            {{ Form::model($user,['url'=>route('users.update',$user),'method'=>'PATCH','enctype'=>"multipart/form-data",]) }}

        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-sm-4">
            <div class="pt-3 text-center">
                <button class="btn btn-success btn-block">Сохранить</button>

            </div>
        </div>
    </div>
    {{ Form::close() }}

@stop
