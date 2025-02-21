<x-pages-layout meta-title="{{ __('My Workouts') }}">
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

                    <!-- Botones de editar y eliminar -->
                    @if(auth()->user()->hasRole('admin') || $workout->user_id == auth()->id())
                        <div class="mt-4 flex space-x-4">
                            <a href="{{ route('workouts.edit', $workout->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('workouts.destroyMy', $workout->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-300">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

</x-pages-layout>
