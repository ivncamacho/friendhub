<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FriendHub</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#022133] text-white">

<!-- Incluir el componente Navbar -->
<x-navbar />

<!-- Sección Services -->
<section id="services" class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold uppercase">Services</h2>
            <h3 class="text-gray-400 text-lg">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
            <div class="p-6 bg-gray-800 rounded-lg shadow-lg">
                <h4 class="text-xl font-semibold mb-3">E-Commerce</h4>
                <p class="text-gray-400">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
            <div class="p-6 bg-gray-800 rounded-lg shadow-lg">
                <h4 class="text-xl font-semibold mb-3">Responsive Design</h4>
                <p class="text-gray-400">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
        </div>
    </div>
</section>

</body>
</html>
