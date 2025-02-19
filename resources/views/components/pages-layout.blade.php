<!DOCTYPE html>
<html lang="{{ session('locale', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle }} - FriendHub</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-[#022133] min-h-screen text-white">

@session('status')
<div class="bg-green-600 p-4 text-xl text-green-50 dark:bg-green-800">
    {{ $value }}
</div>
@endsession
<main>
    {{ $slot }}
</main>
@livewireScripts
</body>
</html>
