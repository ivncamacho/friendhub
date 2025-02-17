<x-pages-layout meta-title="{{ __('Common Exercises') }}">

<x-nav-bar />

<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">{{ __('Common Exercises') }}</h1>

        <!-- Botón para añadir nuevo ejercicio -->
        <div class="text-center mb-8">
            <a href="{{ route('exercise.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                {{ __('Add new exercise') }}
            </a>
        </div>
        <!-- Barra de búsqueda y lista de ejercicios usando Livewire -->
        <livewire:exercise-search />
    </div>
</div>

</x-pages-layout>
