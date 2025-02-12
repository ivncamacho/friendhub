<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('My Workouts') }} - FriendHub</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] min-h-screen text-white">

<!-- Navbar -->
<x-navbar />

<div class="container mx-auto px-4 pt-24 pb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">{{ __('My Workouts') }}</h2>
        <p class="text-gray-400">{{ __('Here you can see your saved workouts.') }}</p>
    </div>

    <!-- Botón para añadir nuevo entrenamiento -->
    <div class="text-center mb-8">
        <a href="{{ route('workouts.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            {{ __('Add new workout') }}
        </a>
    </div>

    @if($workouts->isEmpty())
        <p class="text-center text-gray-400">{{ __('You havent created any workouts yet.') }}</p>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($workouts as $workout)
                <div class="bg-[#033047] p-6 rounded-lg shadow-lg">
                    <!-- Usuario -->
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('profile_images/default-profile.jpg') }}"
                             alt="Perfil de {{ Auth::user()->name }}"
                             class="w-12 h-12 rounded-full border-2 border-gray-500">
                        <div>
                            <h3 class="text-lg font-semibold">{{ Auth::user()->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $workout->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Título -->
                    <h3 class="text-xl font-bold">{{ $workout->title }}</h3>

                    <!-- Botón para ver detalles -->
                    <a href="{{ route('workouts.show', $workout->id) }}"
                       class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                        {{ __('View workout') }}
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
