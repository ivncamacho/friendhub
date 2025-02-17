<x-auth-layout meta-title="{{__('Log In')}}">

<!-- Notificación centrada -->
@if(session('status'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div x-show="show" x-transition:enter="transition transform ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:leave="transition transform ease-in duration-150"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <p>{{ session('status') }}</p>
        </div>
    </div>
@endif

<div class="bg-[#033047] shadow-lg rounded-lg p-8 max-w-md w-full">
    <div class="text-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
        <h2 class="text-2xl font-bold text-white">{{__('Log In')}}</h2>
        <p class="text-gray-300">{{__('Access your account')}}</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="mt-6">
        @csrf

        <!-- Email -->
        <div>
            <label class="block text-gray-300">{{__('Email')}}</label>
            <input type="email" name="email" required class="w-full mt-2 p-3 border border-gray-600 rounded-lg bg-[#022133] text-white focus:outline-none focus:ring-2 focus:ring-[#1E90FF]">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <label class="block text-gray-300">{{__('Password')}}</label>
            <input type="password" name="password" required class="w-full mt-2 p-3 border border-gray-600 rounded-lg bg-[#022133] text-white focus:outline-none focus:ring-2 focus:ring-[#1E90FF]">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center justify-between mt-4">
            <label class="flex items-center text-gray-300">
                <input type="checkbox" name="remember" class="mr-2">
                {{__('Remember Me')}}
            </label>

            <a href="{{ route('password.request') }}" class="text-[#1E90FF] ml-2 text-sm">{{__('Forgot your password?')}}</a>
        </div>

        <!-- Botón de inicio de sesión -->
        <button type="submit" class="w-full bg-[#1E90FF] text-white py-3 rounded-lg mt-6 hover:bg-[#1C86EE] transition duration-300">
            {{__('Log In')}}
        </button>
    </form>

    <p class="text-center text-gray-300 mt-4">{{__('Dont have an account?')}}
        <a href="{{ route('register') }}" class="text-[#1E90FF]">{{__('Register')}}</a>
    </p>
</div>

</x-auth-layout>
