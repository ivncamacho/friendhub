<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Entrenamiento - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
    <h2 class="text-2xl font-bold text-gray-800 text-center">Crear Nuevo Entrenamiento</h2>
    <form action="{{ route('workout.store') }}" method="POST" class="mt-6">
        @csrf

        <!-- Título -->
        <div>
            <label class="block text-gray-700">Título</label>
            <input type="text" name="title" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg">
        </div>

        <!-- Descripción -->
        <div class="mt-4">
            <label class="block text-gray-700">Descripción</label>
            <textarea name="description" class="w-full mt-2 p-3 border border-gray-300 rounded-lg"></textarea>
        </div>

        <!-- Ejercicios -->
        <div class="mt-4">
            <label class="block text-gray-700">Ejercicios</label>
            <div id="exercise-container">
                <div class="exercise-group">
                    <select name="exercises[0][exercise_id]" required class="w-full mt-2 p-2 border border-gray-300 rounded-lg">
                        @foreach($exercises as $exercise)
                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="exercises[0][sets]" placeholder="Series" required class="w-full mt-2 p-2 border border-gray-300 rounded-lg">
                    <input type="number" name="exercises[0][reps]" placeholder="Repeticiones" required class="w-full mt-2 p-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <button type="button" onclick="addExercise()" class="mt-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Añadir otro ejercicio
            </button>
        </div>

        <!-- Botón de guardar -->
        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
            Guardar Entrenamiento
        </button>
    </form>
</div>

<script>
    let exerciseIndex = 1;
    function addExercise() {
        let container = document.getElementById('exercise-container');
        let newGroup = document.createElement('div');
        newGroup.classList.add('exercise-group', 'mt-2');
        newGroup.innerHTML = `
            <select name="exercises[${exerciseIndex}][exercise_id]" required class="w-full p-2 border border-gray-300 rounded-lg">
                @foreach($exercises as $exercise)
        <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                @endforeach
        </select>
        <input type="number" name="exercises[${exerciseIndex}][sets]" placeholder="Series" required class="w-full mt-2 p-2 border border-gray-300 rounded-lg">
            <input type="number" name="exercises[${exerciseIndex}][reps]" placeholder="Repeticiones" required class="w-full mt-2 p-2 border border-gray-300 rounded-lg">
        `;
        container.appendChild(newGroup);
        exerciseIndex++;
    }
</script>

</body>
</html>
