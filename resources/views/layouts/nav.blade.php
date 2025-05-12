<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <!-- Логотип -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-mortarboard"></i> TutorFinder
        </a>

        <!-- Кнопка для мобильных -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Основное меню -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <!-- Публичные ссылки -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tutors.public.show') ? 'active' : '' }}" 
                       href="{{ route('tutors.public.show', 1) }}"> <!-- Пример ID, нужно динамическое решение -->
                        Репетиторы
                    </a>
                </li>
                
                <!-- Для авторизованных пользователей -->
                @auth
                    @if(auth()->user()->isTutor())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tutor.dashboard') ? 'active' : '' }}" 
                               href="{{ route('tutor.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Кабинет
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('student.tutors.*') ? 'active' : '' }}" 
                               href="{{ route('student.tutors.index') }}">
                                <i class="bi bi-search"></i> Найти репетитора
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Правая часть -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <!-- Гость -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" 
                           href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Вход
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" 
                           href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Регистрация
                        </a>
                    </li>
                @else
                    <!-- Авторизованный пользователь -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->photo_url }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle me-2" 
                                 width="30" 
                                 height="30"
                                 style="object-fit: cover;">
                            {{ Str::limit(auth()->user()->name, 15) }}
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" 
                                   href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear"></i> Настройки
                                </a>
                            </li>
                            
                            @if(auth()->user()->isTutor())
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('tutor.profile') ? 'active' : '' }}" 
                                       href="{{ route('tutor.profile') }}">
                                        <i class="bi bi-person-lines-fill"></i> Профиль
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-left"></i> Выход
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>