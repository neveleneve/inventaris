<nav class="navbar navbar-expand navbar-light navbar-bg">
    @guest
        <a href="{{ route('dashboard') }}" class="navbar-brand text-dark fw-bold">
            {{ env('APP_NAME') }}
        </a>
    @else
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>
    @endguest
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('login') ? 'fw-bold' : null }}" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    </li>
                @endif
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i>
                    </a>
                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="text-dark fw-bold fs-4">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

@push('customjs')
@endpush
