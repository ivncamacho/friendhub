<x-pages-layout meta-title="Feed">

<x-nav-bar />

<div class="mt-20 container mx-auto px-4">


    <div class="flex justify-center mb-8">
        <a href="{{ route('workouts.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-lg">
            ➕ {{__('Add new workout')}}
        </a>
    </div>

    <!-- Barra de búsqueda mejorada -->
    <div class="flex justify-center mb-8">
        <input type="text" id="search-bar" placeholder="{{__('Search workout')}}..."
               class="w-1/3 bg-blue-600 text-white py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300"
               onkeyup="filterWorkouts()" />
    </div>

    <!-- Lista de entrenamientos centrada -->
    <div id="workout-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($workouts as $workout)
            <div class="relative bg-[#033047] shadow-lg rounded-lg p-6 workout-item transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-[#044766]">
                <!-- Mostrar botones solo si el usuario es el creador o admin -->
                @if(auth()->user()->hasRole('admin') || $workout->user_id == auth()->id())
                    <div class="absolute top-4 right-4 flex space-x-4">
                        <a href="{{ route('workouts.edit', $workout->id) }}" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600">
                            <i class="fas fa-edit"></i> {{__('Edit')}}
                        </a>
                        <form action="{{ route('workouts.destroy', $workout->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600">
                                <i class="fas fa-trash-alt"></i> {{__('Delete')}}
                            </button>
                        </form>
                    </div>
                @endif

                <a href="{{ route('workouts.show', $workout->id) }}" class="block">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset($workout->user->profile_photo ?   $workout->user->profile_photo : 'profile_images/default-profile.jpg') }}"
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
            </div>
        @endforeach
    </div>
</div>

<script>
    function filterWorkouts() {
        let searchQuery = document.getElementById('search-bar').value.toLowerCase();
        let workouts = document.querySelectorAll('.workout-item');

        workouts.forEach(workout => {
            // Buscar solo por el título
            let title = workout.querySelector('p.text-xl').textContent.toLowerCase();
            let description = workout.querySelector('p.text-gray-300').textContent.toLowerCase();

            if (title.includes(searchQuery) || description.includes(searchQuery)) {
                workout.style.display = '';
            } else {
                workout.style.display = 'none';
            }
        });
    }
</script>

</x-pages-layout>
