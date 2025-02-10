<html>
<head>
    <title>My Workouts</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
</head>
<body>
    <!-- Incluir el componente Navbar -->
    <x-navbar />
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Mis Entrenamientos</h2>
                <h3 class="section-subheading text-muted">Aquí puedes ver tus entrenamientos guardados.</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-6">
                    <h4 class="my-3">Entrenamiento 1</h4>
                    <p class="text-muted
                    ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-6">
                    <h4 class="my-3">Entrenamiento 2</h4>
                    <p class="text-muted
                    ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
