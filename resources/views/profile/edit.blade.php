<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Profile Settings')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-[#022133] text-white flex items-center justify-center min-h-screen">
<div class="bg-[#033047] p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">{{__('Profile Settings')}}</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre de Usuario -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-2">{{__('Username')}}</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full p-3 rounded-lg bg-[#022133] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-2">{{__('Email')}}</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full p-3 rounded-lg bg-[#022133] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-2">{{__('New Password')}}</label>
            <input type="password" name="password" id="password" class="w-full p-3 rounded-lg bg-[#022133] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium mb-2">{{__('Confirm New Password')}}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 rounded-lg bg-[#022133] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Foto de Perfil -->
        @livewire('drag-drop')

        <!-- Botón de Guardar Cambios -->
        <div class="mt-6 flex justify-between items-center">
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300">{{__('Save Changes')}}</button>

            <!-- Botón de Volver Atrás -->
            <a href="javascript:history.back()" class="w-full bg-red-600 text-white py-3 rounded-lg text-center hover:bg-red-700 transition duration-300 ml-4">
                {{__('Go Back')}}
            </a>
        </div>
    </form>

    <div class="mt-3 flex justify-center">
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition duration-300">{{__('Delete Profile Picture')}}</button>
        </form>
    </div>

</div>
</body>
</html>
