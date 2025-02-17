<x-auth-layout meta-title="{{__('New Password')}}">

<div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
    <div class="text-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
        <h2 class="text-2xl font-bold text-gray-800">{{__('New Password')}}</h2>
        <p class="text-gray-600">Ingresa tu nueva contraseña y confírmala para continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6" >
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">


        <!-- Email -->
        <div>
            <label class="block text-gray-700">{{__('Email')}}</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required readonly class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nueva Contraseña -->
        <div class="mt-4">
            <label class="block text-gray-700">{{__('New Password')}}</label>
            <input type="password" name="password" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <label class="block text-gray-700">{{__('Confirm Password')}}</label>
            <input type="password" name="password_confirmation" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón Restablecer -->
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg mt-6 hover:bg-blue-700 transition duration-300">
            {{__('Confirm New Password')}}
        </button>
    </form>

    <p class="text-center text-gray-600 mt-4">¿Recordaste tu contraseña?
        <a href="{{ route('login') }}" class="text-blue-500">Inicia sesión aquí</a>
    </p>
</div>

</x-auth-layout>
