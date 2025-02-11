<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Register')}} - FriendHub</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">{{__('Create Account')}}</h2>

    <!-- Formulario de Registro -->
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <!-- Nombre -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-600">{{__('Name')}}</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#033047]" value="{{ old('name') }}">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-600">{{__('Email')}}</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#033047]" value="{{ old('email') }}">
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-600">{{__('Password')}}</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#033047]">
            @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-600">{{__('Confirm Password')}}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#033047]">
        </div>

        <!-- Botón de Registro -->
        <button type="submit" class="w-full bg-[#033047] hover:bg-[#022133] text-white font-semibold py-2 rounded-lg transition">{{__('Register')}}</button>
    </form>

    <!-- Link para iniciar sesión -->
    <p class="text-sm text-center text-gray-600 mt-4">
        {{__('Already have an account?')}}
        <a href="{{ route('login') }}" class="text-[#033047] hover:underline">{{__('Log In')}}</a>
    </p>
</div>

</body>
</html>
