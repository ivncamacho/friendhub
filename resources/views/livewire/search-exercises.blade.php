<div>
    <input type="text"
           wire:model.debounce.500ms="search"
           placeholder="Buscar ejercicio..."
           class="w-full p-3 text-lg bg-[#033047] border border-gray-700 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">

    <ul class="mt-4">
        @forelse ($exercises as $exercise)
            <li class="text-white">{{ $exercise->title }}</li>
        @empty
            <li class="text-white">No se encontraron ejercicios</li>
        @endforelse
    </ul>
</div>
