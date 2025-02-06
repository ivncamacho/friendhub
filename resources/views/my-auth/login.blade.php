<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - FriendHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] flex items-center justify-center min-h-screen">

<div class="bg-[#033047] shadow-lg rounded-lg p-8 max-w-md w-full">
    <div class="text-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
        <h2 class="text-2xl font-bold text-white">Iniciar Sesión</h2>
        <p class="text-gray-300">Accede a tu cuenta</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="mt-6">
        @csrf

        <!-- Email -->
        <div>
            <label class="block text-gray-300">Correo Electrónico</label>
            <input type="email" name="email" required class="w-full mt-2 p-3 border border-gray-600 rounded-lg bg-[#022133] text-white focus:outline-none focus:ring-2 focus:ring-[#1E90FF]">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <label class="block text-gray-300">Contraseña</label>
            <input type="password" name="password" required class="w-full mt-2 p-3 border border-gray-600 rounded-lg bg-[#022133] text-white focus:outline-none focus:ring-2 focus:ring-[#1E90FF]">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center justify-between mt-4">
            <label class="flex items-center text-gray-300">
                <input type="checkbox" name="remember" class="mr-2">
                Recuérdame
            </label>
            <a href="{{ route('password.request') }}" class="text-[#1E90FF] text-sm">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Botón de inicio de sesión -->
        <button type="submit" class="w-full bg-[#1E90FF] text-white py-3 rounded-lg mt-6 hover:bg-[#1C86EE] transition duration-300">
            Iniciar Sesión
        </button>
    </form>

    <p class="text-center text-gray-300 mt-4">¿No tienes cuenta?
        <a href="{{ route('register') }}" class="text-[#1E90FF]">Regístrate aquí</a>
    </p>
</div>

</body>
</html>
