<?php

use App\Models\Users\Role;

/**
 * @var Role $role
 */
?>
@extends('layouts.app')

@section('content')

    <div class="row pb-3">
        <div class="col">
            {{ Form::open(['url'=>route('roles.index'),'method'=>'get','class'=>'form-inline']) }}
            @include('form._input',[
          'name'=>'search',
          'placeholder'=>'Поиск'
      ])


            <div class="form-group">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-fw fa-search"></i>
                </button>
            </div>


            {{ Form::close() }}
        </div>
        <div class="col-auto">
            <a href="{{ route('roles.create') }}" class="btn btn-outline-success">
                Добавить <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>



    @forelse($roles as $role)
        <div class="row border-bottom py-2">
            <div class="col-1">
                {{ $role->getKey() }}
            </div>

            <div class="col-8">
                {{ $role->getDisplayName() }}

                <br>
                <small class="text-muted">
                    {{ $role->getName() }}
                </small>

            </div>

            <div class="col-lg-3 text-right">
                <div class="btn-group">
                    <a href="{{ route('roles.edit',$role) }}" class="btn btn-outline-secondary">
                        Редактировать
                    </a>
                </div>

                @if ($role->getKey()  > 10)
                    {{ Form::open(['url'=>route('roles.destroy',$role),'method'=>'DELETE','class'=>'btn-group']) }}
                    <button class="btn btn-outline-danger"
                            onclick="return confirm('Удалить пользователя №{{ $role->getKey() }}?')">
                        Удалить?
                    </button>
                    {{ Form::close() }}
                @else
                    <button class="btn btn-outline-danger disabled"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Запрещено удалять базовую роль «{{ $role->getDisplayName() }}»"
                    >
                        Удалить?
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            По запросу ничего не найдено
        </div>
    @endforelse

    @include('form._pagination',[
    'elements'=>$roles,
    ])


@stop
