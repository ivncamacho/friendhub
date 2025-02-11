<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejercicios Comunes - FriendHub</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Contenido de ejercicios comunes -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Ejercicios Comunes</h1>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-8 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Barra de búsqueda -->
        <input type="text" id="search" placeholder="Buscar ejercicios..." class="border-2 border-blue-500 bg-blue-100 p-2 rounded-full w-64 mb-8 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">

        <!-- Botón para añadir nuevo ejercicio -->
        <div class="text-center mb-8">
            <a href="{{ route('exercise.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                Añadir Nuevo Ejercicio
            </a>
        </div>

        <!-- Lista de ejercicios comunes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="exercise-list">
            @foreach ($exercises as $exercise)
                <a href="{{ route('exercise.show', $exercise->id) }}" class="exercise-item relative bg-[#033047] p-6 rounded-lg shadow-lg block transform transition-transform duration-300 hover:scale-105 hover:bg-[#044766]">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ $exercise->title }}</h2>
                    <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}" alt="Imagen de {{ $exercise->title }}" class="w-full h-48 object-cover rounded mb-4">

                    <!-- Propietario del ejercicio -->
                    <div class="absolute bottom-4 left-4 flex items-center space-x-2 bg-[#022133] bg-opacity-80 p-2 rounded-full">
                        <img src="{{ asset('profile_images/' . ($exercise->user->profile_photo ?? 'default-profile.jpg')) }}" alt="{{ $exercise->user->name }}" class="w-8 h-8 rounded-full">
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

<script>
    document.getElementById('search').addEventListener('input', function() {
        let query = this.value.toLowerCase();

        // Obtener todos los ejercicios
        let exercises = document.querySelectorAll('.exercise-item');

        exercises.forEach(function(exercise) {
            let title = exercise.querySelector('h2').innerText.toLowerCase();
            let description = exercise.querySelector('img').alt.toLowerCase(); // Si tienes descripciones

            // Si la búsqueda coincide con el título o la descripción, mostrar el ejercicio
            if (title.includes(query) || description.includes(query)) {
                exercise.style.display = 'block';
            } else {
                exercise.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
