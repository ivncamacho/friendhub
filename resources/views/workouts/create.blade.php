<x-auth-layout meta-title="{{__('Create New Workout')}}">

    <x-nav-bar />

    <div class="bg-[#022133] shadow-lg rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold text-white text-center">{{__('Create New Workout')}}</h2>
        <form action="{{ route('workouts.store') }}" method="POST" class="mt-6">
            @csrf

            <div>
                <label class="block text-gray-300">{{__('Title')}}</label>
                <input type="text" name="title" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mt-4">
                <label class="block text-gray-300">{{__('Description')}}</label>
                <textarea name="description" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="mt-4">
                <label class="block text-gray-300">{{__('Exercises')}}</label>
                <div id="exercise-container">
                    <div class="exercise-group mt-2">
                        <select name="exercises[0][exercise_id]" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white bg-[#1e293b]" id="exercise-select">
                            @foreach($exercises as $exercise)
                                <option value="{{ $exercise->id }}" class="text-black">{{ $exercise->title }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="exercises[0][sets]" placeholder="{{__('Sets')}}" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="number" name="exercises[0][reps]" placeholder="{{__('Reps')}}" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" onclick="removeExercise(this)" class="mt-2 bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                            {{__('Delete')}}
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addExercise()" class="mt-2 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    {{__('Add another exercise')}}
                </button>
            </div>

            <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{__('Save')}}
            </button>
        </form>
    </div>

    <script>
        let exerciseIndex = 1;
        const exercises = @json($exercises);

        function addExercise() {
            let container = document.getElementById('exercise-container');
            let newGroup = document.createElement('div');
            newGroup.classList.add('exercise-group', 'mt-2');

            let options = exercises.map(exercise => {
                return `<option value="${exercise.id}" class="text-black">${exercise.title}</option>`;
            }).join('');

            newGroup.innerHTML = `
        <select name="exercises[${exerciseIndex}][exercise_id]" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white bg-[#1e293b]">
            ${options}
        </select>
        <input type="number" name="exercises[${exerciseIndex}][sets]" placeholder="{{__('Sets')}}" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <input type="number" name="exercises[${exerciseIndex}][reps]" placeholder="{{__('Reps')}}" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="button" onclick="removeExercise(this)" class="mt-2 bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
            {{__('Delete')}}
            </button>
`;
            container.appendChild(newGroup);
            exerciseIndex++;
        }

        function removeExercise(button) {
            let exerciseGroup = button.parentElement;
            exerciseGroup.remove();
        }
    </script>

</x-auth-layout>
