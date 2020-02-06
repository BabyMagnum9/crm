@extends('layouts.app')

@section('content')


    {{ Form::open(['url'=>route('users.store')]) }}

    @include('form._input',[
        'name'=>'email',
        'type'=>'email',
        'required'=>true,
        'label'=>'Электронная почта'
    ])



    @include('form._input',[
    'name'=>'l_name',
      'required'=>true,
    'label'=>'Фамилия'
])

    @include('form._input',[
        'name'=>'f_name',
        'label'=>'Имя'
    ])


    @include('form._input',[
       'name'=>'m_name',
       'label'=>'Отчество'
   ])

    @include('form._input',[
      'name'=>'date_birth',
      'label'=>'Дата рождения'
  ])

    @include('form._input',[
      'name'=>'age',
      'label'=>'Возраст'
  ])

    @include('form._input',[
      'name'=>'password',
      'type'=>'password',
        'required'=>true,
      'label'=>'Пароль'
  ])


    @include('form._input',[
      'name'=>'password_confirmation',
       'type'=>'password',
         'required'=>true,
      'label'=>'Повторение пароля'
  ])

    @include('form._input',[
          'name'=>'image',
           'type'=>'file',
             'required'=>true,
          'label'=>'Изображение'
      ])

    <button class="btn btn-primary">Создать</button>
    {{ Form::close() }}
@stop
