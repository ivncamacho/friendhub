<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<nav class="fixed-top top-0 left-0 w-full bg-[#01121c] shadow-md h-20 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center h-full">
        <!-- Logo -->
        <a href="{{ route('index') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-12 rounded-full">
        </a>

        <!-- Menú Principal -->
        <div class="hidden md:flex space-x-6 uppercase text-lg font-semibold tracking-wide">
            @auth
                <a href="{{ route('index') }}" class="hover:text-gray-400 transition-colors">Inicio</a>
                <a href="{{ route('feed') }}" class="hover:text-gray-400 transition-colors">Feed</a>
            @endauth
        </div>

        <!-- Dropdown Autenticación -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="uppercase hover:text-gray-400 focus:outline-none text-lg font-semibold transition-colors">
                @auth
                    {{ Auth::user()->name }}
                @else
                    Entra
                @endauth
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg overflow-hidden z-50">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Perfil</a>
                    <a href="{{ route('myworkouts') }}" class="block px-4 py-2 hover:bg-gray-200">Mis Entrenamientos</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-200">Registrarse</a>
                    <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-200">Iniciar Sesión</a>
                @endauth
            </div>
        </div>

        <!-- Botón menú móvil -->
        <button @click="openMobile = !openMobile" class="md:hidden focus:outline-none" x-data="{ openMobile: false }">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Menú móvil -->
        <div x-show="openMobile" @click.away="openMobile = false" class="absolute fixed-top top-20 left-0 w-full bg-[#01121c] text-center py-4 shadow-lg md:hidden">
            @auth
                <a href="{{ route('index') }}" class="block py-2 text-lg font-semibold hover:text-gray-400 transition-colors">Inicio</a>
                <a href="{{ route('feed') }}" class="block py-2 text-lg font-semibold hover:text-gray-400 transition-colors">Feed</a>
            @endauth
        </div>
    </div>
</nav>

</body>
</html>
