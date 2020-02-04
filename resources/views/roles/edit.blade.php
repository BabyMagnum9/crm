@extends('layouts.app')

@section('content')

    <div class="div">
        <div class="div">
            {{Form::model($role,['url'=>route('roles.update',$role),'method'=>'PATCH']) }}

            @include('roles._form')

            <div class="div">
                <button class="bth bth-primary" onclick=" return confirm('Вы действительно хотите сохранить?')">Сохранить</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
@stop
