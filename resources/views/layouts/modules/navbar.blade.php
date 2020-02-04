<?php
/**
 * @var \App\Models\Users\User $user
 */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Anime</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @if (auth()->check())
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-fw fa-users"></i> Пользователи</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('roles.index') }}"><i class="fas fa-fw fa-users-cog"></i> Роли</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('permissions.index') }}"><i class="fas fa-fw fa-user-check"></i> Разрешения</a>
            </li>
        </ul>
        @endif
        <ul class="navbar-nav">
            @if (auth()->check())
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->getName()}}  {{Auth::id()}}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item"
                           href="{{ route('users.edit',auth()->user()) }}">Мой профиль</a>
                        <div class="dropdown-divider"></div>
                        {{Form::open(['url'=>route('logout')]) }}
                        <button class="dropdown-item " onclick="return confirm('Вы действительно хотите выйти?')">
                            Выйти
                        </button>
                        {{Form::close()}}
                    </div>
                </li>

            @endif
        </ul>

    </div>
</nav>
