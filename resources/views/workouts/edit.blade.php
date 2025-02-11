<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrenamiento - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] min-h-screen flex items-center justify-center">

<x-nav-bar />

<div class="bg-[#022133] shadow-lg rounded-lg p-8 max-w-lg w-full">
    <h2 class="text-2xl font-bold text-white text-center">Editar Entrenamiento</h2>
    <form action="{{ route('workouts.update', $workout->id) }}" method="POST" class="mt-6">
        @csrf
        @method('PUT') <!-- Se utiliza PUT para actualizar el entrenamiento -->

        <!-- Título -->
        <div>
            <label class="block text-gray-300">Título</label>
            <input type="text" name="title" value="{{ $workout->title }}" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Descripción -->
        <div class="mt-4">
            <label class="block text-gray-300">Descripción</label>
            <textarea name="description" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $workout->description) }}</textarea>
        </div>

        <!-- Ejercicios -->
        <div class="mt-4">
            <label class="block text-gray-300">Ejercicios</label>
            <div id="exercise-container">
                @foreach($workout->exercises as $index => $exercise)
                    <div class="exercise-group mt-2">
                        <select name="exercises[{{ $index }}][exercise_id]" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white bg-[#1e293b]">
                            @foreach($exercises as $exerciseOption)
                                <option value="{{ $exerciseOption->id }}" class="text-black"
                                        @if($exerciseOption->id == $exercise->id) selected @endif>
                                    {{ $exerciseOption->title }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="exercises[{{ $index }}][sets]" value="{{ $exercise->pivot->sets }}" placeholder="Series" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="number" name="exercises[{{ $index }}][reps]" value="{{ $exercise->pivot->reps }}" placeholder="Repeticiones" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addExercise()" class="mt-2 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Añadir otro ejercicio
            </button>
        </div>

        <!-- Botón de guardar -->
        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Guardar Cambios
        </button>
    </form>
</div>

<script>
    let exerciseIndex = {{ count($workout->exercises) }}; // Iniciar el índice para los ejercicios adicionales
    const exercises = @json($exercises); // Pasar los ejercicios como JSON desde Blade

    function addExercise() {
        let container = document.getElementById('exercise-container');
        let newGroup = document.createElement('div');
        newGroup.classList.add('exercise-group', 'mt-2');

        let options = exercises.map(exercise => {
            return `<option value="${exercise.id}" class="text-black">${exercise.title}</option>`;
        }).join(''); // Convertir el array a un string de opciones HTML

        newGroup.innerHTML = `
        <select name="exercises[${exerciseIndex}][exercise_id]" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white bg-[#1e293b]">
            ${options}
        </select>
        <input type="number" name="exercises[${exerciseIndex}][sets]" placeholder="Series" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <input type="number" name="exercises[${exerciseIndex}][reps]" placeholder="Repeticiones" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    `;
        container.appendChild(newGroup);
        exerciseIndex++;
    }
</script>

</body>
</html>
