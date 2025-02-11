<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Ejercicio - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Contenido del formulario -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Editar Ejercicio</h1>

        <!-- Formulario -->
        <form action="{{ route('exercise.update', $exercise->id) }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-[#033047] p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT') <!-- Usamos PUT para la actualización del recurso -->

            <!-- Campo para el título -->
            <div class="mb-4">
                <label for="title" class="block text-white font-semibold mb-2">Título</label>
                <input type="text" name="title" id="title" value="{{ old('title', $exercise->title) }}" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo para la descripción -->
            <div class="mb-4">
                <label for="description" class="block text-white font-semibold mb-2">Descripción</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $exercise->description) }}</textarea>
            </div>

            <!-- Campo para la imagen (opcional) -->
            <div class="mb-4">
                <label for="media" class="block text-white font-semibold mb-2">Imagen (opcional)</label>
                <input type="file" name="media" id="media" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-400 mt-1">Si deseas cambiar la imagen, selecciona una nueva. Si no, deja este campo vacío.</p>
            </div>

            <!-- Campo para el ID del video de YouTube (opcional) -->
            <div class="mb-4">
                <label for="youtube_video_id" class="block text-white font-semibold mb-2">ID del Video de YouTube</label>
                <input type="text" name="youtube_video_id" id="youtube_video_id" value="{{ old('youtube_video_id', $exercise->youtube_video_id) }}" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ejemplo: dQw4w9WgXcQ">
                <p class="text-sm text-gray-400 mt-1">Ingresa solo el ID del video (por ejemplo, en "https://www.youtube.com/watch?v=dQw4w9WgXcQ", el ID es "dQw4w9WgXcQ").</p>
            </div>

            <!-- Botón de envío -->
            <div class="text-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
