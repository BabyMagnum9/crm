@extends('layouts.app')

@section('content')


    <div class="row pb-3 justify-content-end">

        <div class="col-auto">
            <a href="{{ route('permissions.edit',$permission) }}" class="btn btn-outline-success">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-8 col-lg-4">

            {{ Form::model($permission,['url'=>route('permissions.update',$permission),'method'=>'PATCH']) }}

            @include('permissions._form')


            {{ Form::close() }}
        </div>
    </div>

@stop
