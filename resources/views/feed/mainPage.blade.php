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

<div class="mt-20 container mx-auto px-4">
    <!-- Botón para añadir entrenamiento centrado -->
    <div class="flex justify-center mb-8">
        <a href="{{ route('workouts.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-lg">
            ➕ Añadir Nuevo Entrenamiento
        </a>
    </div>

    <!-- Lista de entrenamientos -->
    <div class="space-y-6">
        @foreach($workouts as $workout)
            <div class="bg-[#033047] shadow-lg rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('profile_images/' . ($workout->user->profile_photo ?? 'default-profile.jpg')) }}"
                         alt="{{ $workout->user->name }}"
                         class="w-12 h-12 rounded-full border-2 border-blue-400">
                    <div class="ml-4">
                        <p class="text-white font-semibold">{{ $workout->user->name }}</p>
                        <p class="text-gray-400 text-sm">
                            {{ $workout->created_at ? $workout->created_at->diffForHumans() : 'Fecha no disponible' }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('workouts.show', $workout->id) }}"
                   class="text-xl font-bold text-white hover:text-blue-400 transition">
                    {{ $workout->title }}
                </a>
                <p class="text-gray-300 mt-2">{{ Str::limit($workout->description, 100) }}</p>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
