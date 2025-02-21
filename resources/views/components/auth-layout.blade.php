<!DOCTYPE html>
<html lang="{{ session('locale', app()->getLocale()) }}" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle }} - FriendHub</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-[#022133] flex items-center justify-center min-h-screen ">


<main>
    {{ $slot }}
</main>
@livewireScripts
</body>
</html>
