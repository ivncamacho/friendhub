<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FriendHub</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animación de aparición y desaparición de la notificación */
        .notification {
            position: fixed;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #48bb78; /* Verde */
            color: white;
            padding: 16px 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 4.5s;
            z-index: 50;
        }

        /* Animación de entrada (fadeIn) */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        /* Animación de salida (fadeOut) */
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -40%);
            }
        }
    </style>
</head>
<body class="bg-gray-100">

<x-navbar />

<div class="flex">
    <!-- Sidebar -->
    <aside class="bg-blue-800 text-white w-64 min-h-screen p-5">
        <h2 class="text-lg font-semibold">Menú</h2>
        <ul class="mt-4 space-y-3">
            <li><a href="{{ route('index') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Inicio</a></li>
            <li><a href="{{ route('myworkouts') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Mis Entrenamientos</a></li>
            <li><a href="{{ route('profile.edit') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Configuración</a></li>
        </ul>
    </aside>

    <!-- Contenido Principal -->
    <main class="flex-1 p-6">
        <!-- Notificación de éxito flotante -->
        @if(session('success'))
            <div class="notification">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-800">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-2">Este es tu panel de control, donde puedes ver toda tu información.</p>

        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Publicaciones</h2>
                <p class="text-gray-600">Últimas interacciones en el feed.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Entrenamientos</h2>
                <p class="text-gray-600">Resumen de tu progreso.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Amigos</h2>
                <p class="text-gray-600">Lista de contactos recientes.</p>
            </div>
        </div>
    </main>
</div>

</body>
</html>
