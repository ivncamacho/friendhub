
<body class="bg-[#022133] text-white text-sm">

<nav class="fixed top-0 left-0 w-full bg-[#01121c] shadow-md h-16 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center h-full">

        <a href="{{ route('index') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-10 rounded-full">
        </a>


        @auth
            <div class="hidden md:flex space-x-4 uppercase font-medium tracking-normal bg-[#023e58] p-3 rounded-lg">
                <a href="{{ route('index') }}" class="hover:text-gray-400 transition-colors transform hover:scale-105">{{__('Home')}}</a>
                <a href="{{ route('feed') }}" class="hover:text-gray-400 transition-colors transform hover:scale-105">Feed</a>
                <a href="{{ route('famous-workouts') }}" class="hover:text-gray-400 transition-colors transform hover:scale-105">{{__('Exercises')}}</a>
                <a href="{{ route('myworkouts') }}" class="hover:text-gray-400 transition-colors transform hover:scale-105">{{__('My Workouts')}}</a>
            </div>
        @endauth

        @guest
            <div class="hidden md:flex space-x-4 uppercase font-medium tracking-normal bg-[#023e58] p-3 rounded-lg">
                <a href="{{ route('famous-workouts') }}" class="hover:text-gray-400 transition-colors transform hover:scale-105">{{__('Exercises')}}</a>
            </div>
        @endguest

        <div x-data="{ open: false }" class="relative bg-[#023e58] p-3 rounded-lg">
            <button @click="open = !open" class="uppercase hover:text-gray-400 focus:outline-none font-medium transition-colors">
                @auth
                    <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('profile_images/default-profile.jpg') }}" alt="Foto de perfil" class="w-8 h-8 rounded-full inline-block mr-2">
                    {{ Auth::user()->name }}
                @else
                    {{__('Enter')}}
                @endauth
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white text-black rounded-lg shadow-lg overflow-hidden z-50">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 hover:bg-gray-200 text-sm">{{__('Profile')}}</a>
                    <a href="{{ route('myworkouts') }}" class="block px-3 py-2 hover:bg-gray-200 text-sm">{{__('My Workouts')}}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 hover:bg-gray-200 text-sm">{{__('Log Out')}}</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="block px-3 py-2 hover:bg-gray-200 text-sm">{{__('Register')}}</a>
                    <a href="{{ route('login') }}" class="block px-3 py-2 hover:bg-gray-200 text-sm">{{__('Log In')}}</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

</body>

