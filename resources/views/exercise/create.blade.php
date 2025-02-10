<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Añadir Nuevo Ejercicio - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#022133] text-white">

<x-nav-bar />

<!-- Contenido del formulario -->
<div class="pt-24 pb-12 bg-[#022133]">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Añadir Nuevo Ejercicio</h1>

        <!-- Formulario -->
        <form action="{{ route('exercise.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-[#033047] p-6 rounded-lg shadow-lg">
            @csrf

            <!-- Campo para el título -->
            <div class="mb-4">
                <label for="title" class="block text-white font-semibold mb-2">Título</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo para la descripción -->
            <div class="mb-4">
                <label for="description" class="block text-white font-semibold mb-2">Descripción</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <!-- Campo para la imagen -->
            <div class="mb-4">
                <label for="media" class="block text-white font-semibold mb-2">Imagen</label>
                <input type="file" name="media" id="media" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo para el ID del video de YouTube -->
            <div class="mb-4">
                <label for="youtube_video_id" class="block text-white font-semibold mb-2">ID del Video de YouTube</label>
                <input type="text" name="youtube_video_id" id="youtube_video_id" class="w-full px-4 py-2 bg-[#044766] text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ejemplo: dQw4w9WgXcQ">
                <p class="text-sm text-gray-400 mt-1">Ingresa solo el ID del video (por ejemplo, en "https://www.youtube.com/watch?v=dQw4w9WgXcQ", el ID es "dQw4w9WgXcQ").</p>
            </div>
            <!-- Botón de envío -->
            <div class="text-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Guardar Ejercicio
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
