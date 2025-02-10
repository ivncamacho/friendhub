<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] min-h-screen">

<x-nav-bar />

<!-- Espaciado para evitar que el contenido se solape con la barra de navegación -->
<div class="mt-20 container mx-auto">
    <!-- Botón para añadir entrenamiento centrado -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('workout.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Añadir Entrenamiento
        </a>
    </div>

    <!-- Lista de entrenamientos -->
    <div class="mt-6">
        @foreach($workouts as $workout)
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <a href="{{ route('workout.show', $workout->id) }}" class="text-lg font-bold text-blue-600">
                    {{ $workout->title }}
                </a>
                <p class="text-gray-600">Creado por: {{ $workout->user->name }}</p>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
