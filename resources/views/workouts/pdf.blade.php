<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #022133;
            color: white;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #033047;
            padding: 20px;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid gray;
        }
        .workout-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .description {
            text-align: justify;
            margin-bottom: 20px;
        }
        .exercises {
            margin-top: 20px;
        }
        .exercise {
            background: #04475F;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .exercise h3 {
            margin: 0;
            font-size: 18px;
        }
        .exercise p {
            margin: 5px 0;
        }
        .exercise img {
            width: 50%;
            height: 50%;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Workout Report</h1>
    </div>

    <div class="profile">
        <img src="{{ asset($workout->user->profile_photo ? $workout->user->profile_photo : 'profile_images/default-profile.jpg') }}"
             alt="{{ $workout->user->name }}">
        <div>
            <p><strong>{{ $workout->user->name }}</strong></p>
            <p>{{__('Published on')}} {{ $workout->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="workout-title">{{ $workout->title }}</div>
    <p class="description">{{ $workout->description }}</p>

    <div class="exercises">
        <h2>{{__('Exercises')}}</h2>
        @foreach($workout->exercises as $exercise)
            <div class="exercise">
                <h3>{{ $exercise->title }}</h3>
                <p>{{__('Sets')}}: <strong>{{ $exercise->pivot->sets }}</strong> | {{__('Reps')}}: <strong>{{ $exercise->pivot->reps }}</strong></p>
                <img src="{{ asset('assets/img/exercises/' . $exercise->media) }}"
                     alt="Imagen de {{ $exercise->title }}">
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
