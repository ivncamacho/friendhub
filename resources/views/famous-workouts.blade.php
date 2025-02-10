<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejercicios Comunes - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Contenido de ejercicios comunes -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Ejercicios Comunes</h1>

        <!-- Lista de ejercicios comunes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($exercises as $exercise)
                <a href="{{ route('exercise.show', $exercise->id) }}" class="relative bg-[#033047] p-6 rounded-lg shadow-lg block transform transition-transform duration-300 hover:scale-105 hover:bg-[#044766]">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ $exercise->title }}</h2>
                    <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}" alt="Imagen de {{ $exercise->title }}" class="w-full h-48 object-cover rounded mb-4">

                    <!-- Propietario del ejercicio -->
                    <div class="absolute bottom-4 left-4 flex items-center space-x-2 bg-[#022133] bg-opacity-80 p-2 rounded-full">
                            <img src="{{ asset('profile_images/' . $exercise->user->profile_photo) }}" alt="{{ $exercise->user->name }}" class="w-8 h-8 rounded-full">
                            <span class="text-sm text-white">{{ $exercise->user->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8 text-center">
            {{ $exercises->links() }}
        </div>
    </div>
</div>

</body>
</html>
