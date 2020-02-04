<?php
/**
 * @var \App\Models\Users\User $im
 */
?>
@extends('layouts.app')

@section('content')
    <h1>
        Добро пожаловать
        {{ $im->getFirstName()}}
        {{ $im->getMiddleName()}}
    </h1>
@stop
