<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <li><a href="" class="block py-2 px-4 rounded hover:bg-blue-700">Configuración</a></li>
        </ul>
    </aside>

    <!-- Contenido Principal -->
    <main class="flex-1 p-6">
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
