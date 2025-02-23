<div>
    <!-- Barra de búsqueda -->
    <input type="text"
           wire:model.live="search"
    placeholder="{{ __('Search exercises') }}..."
    class="border-2 border-blue-500 bg-blue-100 p-2 rounded-full w-64 mb-8 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">

    <!-- Lista de ejercicios comunes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($exercises as $exercise)
            <div class="exercise-item relative bg-[#033047] p-6 rounded-lg shadow-lg hover:scale-105 hover:bg-[#044766] transform transition-transform duration-300">
                @auth
                    @if(Gate::allows('authorExercise', $exercise))
                        <div class="absolute top-4 right-4 flex space-x-4">
                            <a href="{{ route('exercise.edit', $exercise->id) }}" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                            <form action="{{ route('exercise.destroy', $exercise->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600">
                                    <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
                <a href="{{ route('exercise.show', $exercise->id) }}" class="block">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ $exercise->title }}</h2>
                    <img src="{{ asset('assets/img/exercises/' . $exercise->media ) }}" alt="Imagen de {{ $exercise->title }}" class="w-full h-48 object-cover rounded mb-4">

                    <div class="absolute bottom-4 left-4 flex items-center space-x-2 bg-[#022133] bg-opacity-80 p-2 rounded-full">
                        <img src="{{ asset($exercise->user->profile_photo ?  $exercise->user->profile_photo : 'profile_images/default-profile.jpg') }}" alt="{{ $exercise->user->name }}" class="w-8 h-8 rounded-full">
                        <span class="text-sm text-white">{{ $exercise->user->name }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="mt-8 text-center">
        {{ $exercises->links() }}
    </div>
</div>
