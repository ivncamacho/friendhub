<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $exercise->title }} - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Detalles del ejercicio -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <div class="bg-[#033047] p-8 rounded-lg shadow-lg text-center">
            <!-- Botón para volver atrás -->
            <div class="mb-6 text-left">
                <a href="{{ route('famous-workouts') }}"
                   class="bg-[#04475F] hover:bg-[#05627F] text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300">
                    ← Volver Atrás
                </a>
            </div>

            <!-- Título -->
            <h1 class="text-3xl font-bold text-white mb-6">{{ $exercise->title }}</h1>

            <!-- Imagen más pequeña -->

            <div class="flex justify-center">
                <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}"
                     alt="Imagen de {{ $exercise->title }}"
                     class="max-w-[500px] max-h-[300px] object-cover rounded mb-6 shadow-lg">
            </div>

            <!-- Descripción -->
            <p class="text-gray-400 mb-6 text-lg">{{ $exercise->description }}</p>

            <!-- Video de YouTube -->
            <div class="mb-6 flex justify-center">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/{{ $exercise->youtube_video_id }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="rounded-lg shadow-lg">
                </iframe>
            </div>
        </div>
    </div>
</div>


</body>
</html>
