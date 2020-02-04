<?php

use App\Models\Users\permission;

/**
 * @var permission $permission
 */
?>
@extends('layouts.app')

@section('content')

    <div class="row pb-3">
        <div class="col">
            {{ Form::open(['url'=>route('permissions.index'),'method'=>'get','class'=>'form-inline']) }}
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
            <a href="{{ route('permissions.create') }}" class="btn btn-outline-success">
                Добавить <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>



    @forelse($permissions as $permission)
        <div class="row border-bottom py-2">
            <div class="col-1">
                {{ $permission->getKey() }}
            </div>

            <div class="col-8">
                {{ $permission->getDisplayName() }}

                <br>
                <small class="text-muted">
                    {{ $permission->getName() }}
                </small>

            </div>

            <div class="col-lg-3 text-right">
                <div class="btn-group">
                    <a href="{{ route('permissions.edit',$permission) }}" class="btn btn-outline-secondary">
                        Редактировать
                    </a>
                </div>

                {{ Form::open(['url'=>route('permissions.destroy',$permission),'method'=>'DELETE','class'=>'btn-group']) }}
                <button class="btn btn-outline-danger"
                        onclick="return confirm('Удалить пользователя №{{ $permission->getKey() }}?')">
                    Удалить?
                </button>
                {{ Form::close() }}

            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            По запросу ничего не найдено
        </div>
    @endforelse

    @include('form._pagination',[
    'elements'=>$permissions,
    ])


@stop
