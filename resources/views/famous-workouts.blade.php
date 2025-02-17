<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Common Exercises') }} - FriendHub</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">{{ __('Common Exercises') }}</h1>

        <!-- Barra de búsqueda y lista de ejercicios usando Livewire -->
        <livewire:exercise-search />
    </div>
</div>


@livewireScripts
</body>
</html>
