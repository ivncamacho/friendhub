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

    <!-- Barra de búsqueda mejorada -->
    <div class="flex justify-center mb-8">
        <input type="text" id="search-bar" placeholder="Buscar entrenamiento..."
               class="w-1/3 bg-blue-600 text-white py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300"
               onkeyup="filterWorkouts()" />
    </div>

    <!-- Lista de entrenamientos centrada -->
    <div id="workout-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($workouts as $workout)
            <a href="{{ route('workouts.show', $workout->id) }}"
               class="bg-[#033047] shadow-lg rounded-lg p-6 workout-item transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-[#044766]">
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

                <p class="text-xl font-bold text-white hover:text-blue-400 transition">
                    {{ $workout->title }}
                </p>
                <p class="text-gray-300 mt-2 text-sm">{{ Str::limit($workout->description, 100) }}</p>
            </a>
        @endforeach
    </div>
</div>

<script>
    function filterWorkouts() {
        let searchQuery = document.getElementById('search-bar').value.toLowerCase();
        let workouts = document.querySelectorAll('.workout-item');

        workouts.forEach(workout => {
            let title = workout.querySelector('p').textContent.toLowerCase();
            let description = workout.querySelector('p.text-gray-300').textContent.toLowerCase();

            if (title.includes(searchQuery) || description.includes(searchQuery)) {
                workout.style.display = '';
            } else {
                workout.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
