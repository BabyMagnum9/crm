@extends('layouts.app')

@section('content')


    <div class="row pb-3 justify-content-end">

        <div class="col-auto">
            <a href="{{ route('roles.edit',$role) }}" class="btn btn-outline-success">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-8 col-lg-4">

            {{ Form::model($role,['url'=>route('roles.update',$role),'method'=>'PATCH']) }}

            @include('roles._form')


            {{ Form::close() }}
        </div>
    </div>

@stop
