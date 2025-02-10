<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $workout->title }} - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Detalles del entrenamiento -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <div class="bg-[#033047] p-8 rounded-lg shadow-lg text-center">
            <!-- Botón para volver atrás -->
            <div class="mb-6 text-left">
                <a href="{{ url()->previous() }}"
                   class="bg-[#04475F] hover:bg-[#05627F] text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300">
                    ← Volver Atrás
                </a>
            </div>

            <!-- Título -->
            <h1 class="text-3xl font-bold text-white mb-6">{{ $workout->title }}</h1>

            <!-- Descripción -->
            <p class="text-gray-400 mb-6 text-lg">{{ $workout->description }}</p>

            <!-- Lista de ejercicios -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-white mb-4">Ejercicios del Entrenamiento</h2>
                <ul class="space-y-4">
                    @foreach($workout->exercises as $exercise)
                        <li class="bg-[#04475F] p-4 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-white">{{ $exercise->title }}</h3>
                            <p class="text-gray-400">Series: {{ $exercise->pivot->sets }} | Repeticiones: {{ $exercise->pivot->reps }}</p>
                            <div class="mt-2">
                                <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}"
                                     alt="Imagen de {{ $exercise->title }}"
                                     class="max-w-[500px] max-h-[300px] object-cover rounded mb-4 shadow-lg">
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Video de YouTube (si está disponible en el entrenamiento) -->
            @if($workout->youtube_video_id)
                <div class="mb-6 flex justify-center">
                    <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/{{ $workout->youtube_video_id }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="rounded-lg shadow-lg">
                    </iframe>
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
