<?php

// Home
use App\Models\Users\Permission;
use App\Models\Users\Role;
use App\Models\Users\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

try {
    /**
     * Домашний маршрут
     */
    Breadcrumbs::for('home', function (BreadcrumbsGenerator $trail) {
        $trail->push('Anime', route('home'));
    });


    /**
     * Авторизация
     */
    Breadcrumbs::for('login', function (BreadcrumbsGenerator $trail) {
        $trail->parent('home');
        $trail->push('Вход в Anime', route('login'));
    });

    Breadcrumbs::for('password.request', function (BreadcrumbsGenerator $trail) {
        $trail->parent('login');
        $trail->push('Запрос на восстановление пароля', route('password.request'));
    });

    /**
     * Пользователи
     */
    Breadcrumbs::for('users.index', function (BreadcrumbsGenerator $trail) {
        $trail->parent('home');
        $trail->push('Пользователи', route('users.index'));
    });


    Breadcrumbs::for('users.create', function (BreadcrumbsGenerator $trail) {
        $trail->parent('users.index');
        $trail->push('Добавить', route('users.create'));
    });


    Breadcrumbs::for('users.show', function (BreadcrumbsGenerator $trail, User $user) {
        $trail->parent('users.index');
        $trail->push($user->getName(), route('users.show', $user));
    });


    Breadcrumbs::for('users.edit', function (BreadcrumbsGenerator $trail, User $user) {
        $trail->parent('users.show', $user);
        $trail->push('Управление', route('users.edit', $user));
    });


    Breadcrumbs::for('users.roles', function (BreadcrumbsGenerator $trail, User $user) {
        $trail->parent('users.show', $user);
        $trail->push('Роли', route('users.roles', $user));
    });


    /**
     * Роли
     */
    Breadcrumbs::for('roles.index', function (BreadcrumbsGenerator $trail) {
        $trail->parent('home');
        $trail->push('Роли', route('roles.index'));
    });


    Breadcrumbs::for('roles.create', function (BreadcrumbsGenerator $trail) {
        $trail->parent('roles.index');
        $trail->push('Добавить', route('roles.create'));
    });


    Breadcrumbs::for('roles.show', function (BreadcrumbsGenerator $trail, Role $role) {
        $trail->parent('roles.index');
        $trail->push($role->getDisplayName(), route('roles.show', $role));
    });


    Breadcrumbs::for('roles.edit', function (BreadcrumbsGenerator $trail, Role $role) {
        $trail->parent('roles.show', $role);
        $trail->push('Управление', route('roles.edit', $role));
    });



    /**
     * Разрешения
     */
    Breadcrumbs::for('permissions.index', function (BreadcrumbsGenerator $trail) {
        $trail->parent('home');
        $trail->push('Разрешения', route('permissions.index'));
    });


    Breadcrumbs::for('permissions.create', function (BreadcrumbsGenerator $trail) {
        $trail->parent('permissions.index');
        $trail->push('Добавить', route('permissions.create'));
    });


    Breadcrumbs::for('permissions.show', function (BreadcrumbsGenerator $trail, Permission $permission) {
        $trail->parent('permissions.index');
        $trail->push($permission->getDisplayName(), route('permissions.show', $permission));
    });


    Breadcrumbs::for('permissions.edit', function (BreadcrumbsGenerator $trail, Permission $permission) {
        $trail->parent('permissions.show', $permission);
        $trail->push('Управление', route('permissions.edit', $permission));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {
    echo 'Ошибка генерации хлебрных крошек:' . $e->getMessage();
}
