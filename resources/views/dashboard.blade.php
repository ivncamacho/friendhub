<x-pages-layout meta-title="{{ __('Dashboard') }}">

<x-navbar />

<div class="flex mt-16">

    <aside class="bg-blue-800 text-white w-64 min-h-screen p-5">
        <h2 class="text-lg font-semibold">{{ __('Menu') }}</h2>
        <ul class="mt-4 space-y-3">
            <li><a href="{{ route('index') }}" class="block py-2 px-4 rounded hover:bg-blue-700">{{ __('Home') }}</a></li>
            <li><a href="{{ route('myworkouts') }}" class="block py-2 px-4 rounded hover:bg-blue-700">{{ __('My Workouts') }}</a></li>
            <li><a href="{{ route('profile.edit') }}" class="block py-2 px-4 rounded hover:bg-blue-700">{{ __('Settings') }}</a></li>
        </ul>
    </aside>

        <h1 class="text-2xl font-bold p-5" >{{ __('Welcome') }}, {{ Auth::user()->name }}</h1>
</div>

</x-pages-layout>
