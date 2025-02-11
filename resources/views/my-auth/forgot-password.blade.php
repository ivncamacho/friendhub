<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Recover Password')}} - FriendHub</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
    <div class="text-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
        <h2 class="text-2xl font-bold text-gray-800">{{__('Recover Password')}}</h2>
        <p class="text-gray-600">{{__('Enter your email and we will send you a link to reset your password.')}}</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6">
        @csrf

        <!-- Email -->
        <div>
            <label class="block text-gray-700">{{__('Email')}}</label>
            <input type="email" name="email" required autofocus class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón de enviar -->
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg mt-6 hover:bg-blue-700 transition duration-300">
            {{__('Send recovery link')}}
        </button>
    </form>

    <p class="text-center text-gray-600 mt-4">{{__('Did you remember your password?')}}
        <a href="{{ route('login') }}" class="text-blue-500">{{__('Log In')}}</a>
    </p>
</div>

</body>
</html>
