<x-pages-layout meta-title="{{ $workout->title }}">

    <x-nav-bar />

    <div class="pt-24 pb-12 bg-[#022133]">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-[#033047] p-6 rounded-lg shadow-lg">

                <div class="flex items-center space-x-4 mb-6">
                    <img src="{{ asset($workout->user->profile_photo ?   $workout->user->profile_photo : 'profile_images/default-profile.jpg') }}"
                         alt="{{ $workout->user->name }}"
                         class="w-12 h-12 rounded-full border-2 border-gray-500">
                    <div>
                        <h2 class="text-lg font-semibold">{{ $workout->user->name }}</h2>
                        <p class="text-gray-400 text-sm">{{__('Published on')}} {{ $workout->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-white mb-4">{{ $workout->title }}</h1>

                <p class="text-gray-300 mb-6">{{ $workout->description }}</p>

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

                <div class="text-center mt-6">
                    <a href="{{ route('workout.pdf', $workout->id) }}"
                       class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                        {{ __('Download PDF') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-pages-layout>
