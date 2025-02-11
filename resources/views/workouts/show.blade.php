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

<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-[#033047] p-6 rounded-lg shadow-lg">
            <!-- Propietario del entrenamiento -->
            <div class="flex items-center space-x-4 mb-6">
                <img src="{{ asset('profile_images/' . ($workout->user->profile_photo ?? 'default-profile.jpg')) }}"
                     alt="{{ $workout->user->name }}"
                     class="w-12 h-12 rounded-full border-2 border-gray-500">
                <div>
                    <h2 class="text-lg font-semibold">{{ $workout->user->name }}</h2>
                    <p class="text-gray-400 text-sm">{{__('Published on')}} {{ $workout->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Título -->
            <h1 class="text-3xl font-bold text-white mb-4">{{ $workout->title }}</h1>

            <!-- Descripción -->
            <p class="text-gray-300 mb-6">{{ $workout->description }}</p>

            <!-- Lista de ejercicios -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-4">{{__('Exercises')}}</h2>
                <div class="space-y-4">
                    @foreach($workout->exercises as $exercise)
                        <div class="bg-[#04475F] p-4 rounded-lg shadow-md">
                            <h3 class="text-lg font-bold text-white">{{ $exercise->title }}</h3>
                            <p class="text-gray-400">{{__('Sets')}}: <span class="font-bold">{{ $exercise->pivot->sets }}</span> | Reps: <span class="font-bold">{{ $exercise->pivot->reps }}</span></p>
                            <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}"
                                 alt="Imagen de {{ $exercise->title }}"
                                 class="w-full h-40 object-cover rounded mt-2 shadow-lg">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Video de YouTube -->
            @if($workout->youtube_video_id)
                <div class="mt-6 flex justify-center">
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
