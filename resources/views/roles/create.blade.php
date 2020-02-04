@extends('layouts.app')

@section('content')


    {{ Form::open(['url'=>route('roles.store')]) }}

    @include('form._input',[
        'name'=>'name',
        'required'=>true,
        'label'=>'Системное имя'
    ])


    @include('form._input',[
    'name'=>'display_name',
    'required'=>true,
    'label'=>'Имя'
])

    @include('form._input',[
        'name'=>'description',
        'label'=>'Описание роли'
    ])


    <button class="btn btn-primary">Создать</button>
    {{ Form::close() }}
@stop
