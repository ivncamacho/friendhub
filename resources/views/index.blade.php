<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página de Inicio - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Contenido principal -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4 text-center">
        @auth
            <h1 class="text-3xl font-bold mb-4">Bienvenido/a de nuevo, {{ Auth::user()->name }}!</h1>
            <p class="text-lg mb-8">Nos alegra verte nuevamente. Explora las últimas novedades y mantente conectado con tus amigos.</p>
            <!-- Botón para ver el feed de noticias -->
            <a href="{{ route('feed') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                Ir al Feed de Noticias
            </a>
        @else
            <h1 class="text-3xl font-bold mb-4">Bienvenido/a a FriendHub</h1>
            <p class="text-lg mb-8">Conéctate con amigos, comparte momentos y descubre nuevas comunidades.</p>
            <!-- Botones de registro e inicio de sesión -->
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                    Regístrate
                </a>
                <a href="{{ route('login') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                    Inicia Sesión
                </a>
            </div>
        @endauth
    </div>
</div>

</body>
</html>
