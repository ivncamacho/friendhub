<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ejercicio</title>
</head>
<body>
<h1>¡¡Atencion!!!</h1>
<p>Alguien ha compartido un nuevo ejercicio en la plataforma.</p>

    <h2 class="accent-blue-600">Ejercicio: {{ $exercise->title }}</h2>
    <p>{{ $exercise->description }}</p>

<p>¡Disfruta entrenando!</p>
<p>Desde el equipo directivo de FriendHub</p>
</body>
</html>
