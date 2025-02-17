<x-pages-layout meta-title="{{ __('Home') }}">
<x-nav-bar />

<div class="absolute inset-0 w-full h-full overflow-hidden z-[-1]">
    <video class="w-full h-full object-cover" autoplay loop muted playsinline>
        <source src="{{ asset('assets/vid/background.mp4') }}" type="video/mp4">
        {{ __('Your browser does not support the video tag.') }}
    </video>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
</div>

<!-- Contenido principal -->
<div class="relative min-h-screen pt-24 pb-12 z-10">
    <div class="container mx-auto px-4 text-center">
        @auth
            <h1 class="text-3xl font-bold mb-4">{{ __('Welcome back,') }} {{ Auth::user()->name }}!</h1>
            <p class="text-lg mb-8">{{ __('We are happy to see you again. Explore the latest news and stay connected with your friends.') }}</p>
            <!-- Botón para ver el feed de noticias -->
            <a href="{{ route('feed') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                {{ __('Go to news feed') }}
            </a>
        @else
            <h1 class="text-3xl font-bold mb-4">{{ __('Welcome to FriendHub') }}</h1>
            <p class="text-lg mb-8">{{ __('Connect with friends, share moments, and discover new communities.') }}</p>

            <!-- Botones de registro e inicio de sesión -->
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                    {{ __('Register') }}
                </a>
                <a href="{{ route('login') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">
                    {{ __('Log In') }}
                </a>
            </div>
        @endauth
    </div>
</div>


</x-pages-layout>
