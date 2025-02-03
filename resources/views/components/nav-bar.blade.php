
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar" style="background-color: #01121c; height: 80px" id="mainNav">
    <div class="container">
        <!-- Agregar la imagen a la izquierda con borde redondeado -->
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="rounded-full" style="height: 60px; margin-right: 20px">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto text-uppercase py-4 py-lg-0">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('feed') }}">Feed</a></li>
                @endauth
            </ul>
            <ul class="navbar-nav text-uppercase py-4 py-lg-0">
                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <!-- Muestra el nombre del usuario logueado -->
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('myworkouts') }}">Mis Entrenamientos</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth

                    @guest
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Entra
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('register') }}">Registrarse</a></li>
                            <li><a class="dropdown-item" href="{{ route('login') }}">Iniciar Sesión</a></li>
                        </ul>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
